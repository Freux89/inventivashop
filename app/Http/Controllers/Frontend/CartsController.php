<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Auth;

class CartsController extends Controller
{
    # all cart items
    public function index()
    {
        $carts = null;
        if (Auth::check()) {
            $carts          = Cart::where('user_id', Auth::user()->id)->where('location_id', session('stock_location_id'))->get();
        } else {
            $carts          = Cart::where('guest_user_id', (int) $_COOKIE['guest_user_id'])->where('location_id', session('stock_location_id'))->get();
        }
        return getView('pages.checkout.carts', ['carts' => $carts]);
    }

    # add to cart
    public function store(Request $request)
    {
       
        $productVariationIds = explode(',', $request->product_variation_id);
        
        // Verifica che tutti gli ID esistano
        $productVariations = ProductVariation::whereIn('id', $productVariationIds)->get();
        
        if ($productVariations->count()  != count($productVariationIds)) {
            // Non tutti gli ID sono validi
            return response()->json(['error' => 'Invalid product variation IDs provided.'], 400);
        }

        // Ottenere il carrello dell'utente attuale o del visitatore
        $cartQuery = Auth::check() ?
        Cart::where('user_id', Auth::user()->id)->where('location_id', session('stock_location_id')) :
        Cart::where('guest_user_id', (int) $_COOKIE['guest_user_id'])->where('location_id', session('stock_location_id'));


        $cart = $cartQuery->withCount(['product_variations' => function ($query) use ($productVariationIds) {
            $query->whereIn('product_variation_id', $productVariationIds);
        }])->having('product_variations_count', '=', count($productVariationIds))->first();
        
        $productId = $productVariations->first()->product_id;

        if ($cart) {
            $cart->qty += (int) $request->quantity;
            $message = localize('Quantity has been increased');
        } else {
            $cart = new Cart;
            $cart->qty = (int) $request->quantity;
            $cart->product_id = $productId;
            $cart->location_id = session('stock_location_id');
            
            if (Auth::check()) {
                $cart->user_id = Auth::user()->id;
            } else {
                $cart->guest_user_id = (int) $_COOKIE['guest_user_id'];
            }

            $cart->save();

            // Aggiungi le relazioni nella tabella pivot
            foreach ($productVariationIds as $variationId) {
                $cart->product_variations()->attach($variationId);
            }

            $message = localize('Product added to your cart');
        }

        $cart->save();

        // remove coupon
        removeCoupon();
        return $this->getCartsInfo($message, false);
    }


    # update cart
    public function update(Request $request)
{
    try {
        $cart = Cart::where('id', $request->id)->firstOrFail();

        if ($request->action == "increase") {
            $canIncrease = true;
            foreach ($cart->product_variations as $product_variation) {
                $productVariationStock = $product_variation->product_variation_stock;
                if ($productVariationStock->stock_qty <= $cart->qty) {
                    $canIncrease = false;
                    break;  // Break out of the loop if any variation doesn't have enough stock
                }
            }

            if ($canIncrease) {
                $cart->qty += 1;
                $cart->save();
            }
        } elseif ($request->action == "decrease") {
            if ($cart->qty > 1) {
                $cart->qty -= 1;
                $cart->save();
            }
        } else {
            $cart->delete();
        }

    } catch (\Throwable $th) {
        // Log or handle the exception as you see fit.
    }

    removeCoupon();
    return $this->getCartsInfo('', false);
}


    # apply coupon
    public function applyCoupon(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)->first();
        if ($coupon) {
            $date = strtotime(date('d-m-Y H:i:s'));

            # check if coupon is not expired
            if ($coupon->start_date <= $date && $coupon->end_date >= $date) {

                $carts = null;
                if (Auth::check()) {
                    $carts          = Cart::where('user_id', Auth::user()->id)->where('location_id', session('stock_location_id'))->get();
                } else {
                    $carts          = Cart::where('guest_user_id', (int) $_COOKIE['guest_user_id'])->where('location_id', session('stock_location_id'))->get();
                }

                # check min spend
                $subTotal = (float) getSubTotal($carts, false);
                if ($subTotal >= (float) $coupon->min_spend) {

                    # check if coupon is for categories or products
                    if ($coupon->product_ids || $coupon->category_ids) {
                        if ($carts && validateCouponForProductsAndCategories($carts, $coupon)) {
                            # SUCCESS:: can apply coupon
                            setCoupon($coupon);
                            return $this->getCartsInfo(localize('Coupon applied successfully'), true, $coupon->code);
                        }

                        # coupon not valid for your cart items  
                        removeCoupon();
                        return $this->couponApplyFailed(localize('Coupon is only applicable for selected products or categories'));
                    }

                    # SUCCESS::can apply coupon - not product or category based
                    setCoupon($coupon);
                    return $this->getCartsInfo(localize('Coupon applied successfully'), true, $coupon->code);
                }

                # min spend
                removeCoupon();
                return $this->couponApplyFailed('Please shop for atleast ' . formatPrice($coupon->min_spend));
            }

            # expired 
            removeCoupon();
            return $this->couponApplyFailed(localize('Coupon is expired'));
        }

        // coupon not found
        removeCoupon();
        return $this->couponApplyFailed(localize('Coupon is not valid'));
    }

    # coupon apply failed
    private function couponApplyFailed($message = '', $success = false)
    {
        $response = $this->getCartsInfo($message, false);
        $response['success'] = $success;
        return $response;
    }

    # clear coupon
    public function clearCoupon()
    {
        removeCoupon();
        return $this->couponApplyFailed(localize('Coupon has been removed'), true);
    }

    # get cart information
    private function getCartsInfo($message = '', $couponDiscount = true, $couponCode = '')
    {
       
        $carts = null;
        if (Auth::check()) {
            $carts          = Cart::where('user_id', Auth::user()->id)->where('location_id', session('stock_location_id'))->get();
        } else {
            $carts          = Cart::where('guest_user_id', (int) $_COOKIE['guest_user_id'])->where('location_id', session('stock_location_id'))->get();
        }

        return [
            'success'           => true,
            'message'           => $message,
            'carts'             => getViewRender('pages.partials.carts.cart-listing', ['carts' => $carts]),
            'navCarts'          => getViewRender('pages.partials.carts.cart-navbar', ['carts' => $carts]),
            'cartCount'         => count($carts),
            'subTotal'          => formatPrice(getSubTotal($carts, $couponDiscount, $couponCode)),
            'couponDiscount'    => formatPrice(getCouponDiscount(getSubTotal($carts, false), $couponCode)),
        ];
    }
}
