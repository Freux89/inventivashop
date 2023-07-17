<?php

namespace App\Http\Controllers\Backend\Pos;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Language;
use App\Models\Location;
use App\Models\Order;
use App\Models\OrderGroup;
use App\Models\OrderItem;
use App\Models\OrderUpdate;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductVariation;
use App\Models\User;
use App\Notifications\AccountCreatedFromPos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Notification;
use Illuminate\Support\Facades\Hash;
use Session;
use PDF;

class PosController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:pos'])->only('index');
    }

    # return pos page
    public function index(Request $request)
    {
        $searchKey = null;
        $locations = Location::where('is_published', 1)->latest()->get();
        $categories = Category::latest()->get();
        $brands = Brand::isActive()->get();
        return view('backend.pages.pos.index', compact('locations', 'categories', 'brands', 'searchKey'));
    }

    # return pos products
    public function products(Request $request)
    {
        $products = Product::isPublished()
            ->latest();

        if ($request->search != null) {
            $products = $products->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->category_id != null) {
            $productIds = ProductCategory::where('category_id', $request->category_id)->pluck('product_id');
            $products = $products->whereIn('id', $productIds);
        }

        if ($request->brand_id != null) {
            $products = $products->where('brand_id', $request->brand_id);
        }

        $products  = $products->paginate(paginationNumber(30))->appends(request()->query());
        return [
            'status' => true,
            'products' => view('backend.pages.pos.inc.products', compact('products'))->render(),
            'productsQuery' => $products
        ];
    }

    # return customers
    public function customers(Request $request)
    {
        $customers = User::where('user_type', 'customer')->where('is_banned', 0)->latest()->get();
        return [
            'status' => true,
            'customers' => view('backend.pages.pos.inc.customers', compact('customers'))->render(),
        ];
    }

    # return customerInfo
    public function customerInfo(Request $request)
    {
        $customer = User::findOrFail((int)$request->customer_id);
        return [
            'status' => true,
            'customer' => new UserResource($customer)
        ];
    }

    # return new customer info
    public function newCustomer(Request $request)
    {
        $customer = new User;
        $customer->name = $request->new_pos_customer_name;
        $customer->phone = $request->new_pos_customer_phone;
        $customer->password = Hash::make('123456');
        $customer->email_or_otp_verified = 1;
        $customer->email_verified_at = Carbon::now();
        $customer->save();

        if ($request->email == null) {
            $customer->email = "poscustomer" . $customer->id . "@example.com";
        } else {
            $customer->email = $request->new_pos_customer_email;
        }
        $customer->save();

        try {
            Notification::send($customer, new AccountCreatedFromPos($customer));
        } catch (\Throwable $th) {
            //throw $th;
        }
        return [
            'status' => true,
            'customer' => new UserResource($customer)
        ];
    }

    # addToList
    public function addToList(Request $request)
    {
        $responseData = [
            'status' => true,
        ];

        $carts = [];

        // old 
        if ($request->product_variation_ids != null) {
            foreach ($request->product_variation_ids as $key => $productVariationId) {
                $tempCart = new Cart;
                $tempCart->product_variation_id = $productVariationId;
                $tempCart->qty = $request->quantities[$key];
                array_unshift($carts, $tempCart);
            }
        }

        // new
        $productVariation = ProductVariation::where('id', $request->product_variation_id)->first();
        $productVariationStock = $productVariation->product_variation_stock; // if null, out of stock for this location

        if (is_null($productVariationStock)) {
            // stock entry not available
            $responseData = [
                'status'    => false,
                'message'   => localize('This product is out of stock for this location'),
                'carts'     => view('backend.pages.pos.inc.pos-cart', compact('carts'))->render(),
                'posSummary'     => view('backend.pages.pos.inc.posSummary', compact('carts'))->render(),
            ];
            return $responseData;
        } else {
            // stock entry available in system but check qty
            $stock = $productVariationStock->stock_qty;

            if ($request->product_variation_ids != null) {
                // check if this item has been added to list previously
                $isExists = in_array($request->product_variation_id, $request->product_variation_ids);
                if ($isExists) {
                    $indexOfNewVariationInAddedCartList = array_search($request->product_variation_id, $request->product_variation_ids);
                    $prevQty = $request->quantities[$indexOfNewVariationInAddedCartList];

                    if ($stock > $prevQty) {
                        // add to cart list 
                        $tempCarts = [];
                        foreach ($carts as $cartKey => $cart) {
                            if ($cart->product_variation_id == $request->product_variation_id) {
                                $cart->qty += 1;
                            }
                            array_unshift($tempCarts, $cart);
                        }
                        $carts = $tempCarts;

                        $responseData = [
                            'status'    => true,
                            'message'   => '',
                            'carts'     => view('backend.pages.pos.inc.pos-cart', compact('carts'))->render(),
                            'posSummary'     => view('backend.pages.pos.inc.posSummary', compact('carts'))->render(),
                        ];
                        return $responseData;
                    } else {
                        // max stock qty reached
                        $responseData = [
                            'status'    => false,
                            'message'   => localize('No more stock left of this product'),
                            'carts'     => view('backend.pages.pos.inc.pos-cart', compact('carts'))->render(),
                            'posSummary'     => view('backend.pages.pos.inc.posSummary', compact('carts'))->render(),
                        ];
                        return $responseData;
                    }
                } else {
                    // add item to existing list
                    if ($stock > 0) {
                        $tempCart = new Cart;
                        $tempCart->product_variation_id = $request->product_variation_id;
                        $tempCart->qty = 1;
                        array_unshift($carts, $tempCart);

                        $responseData = [
                            'status'    => true,
                            'message'   => '',
                            'carts'     => view('backend.pages.pos.inc.pos-cart', compact('carts'))->render(),
                            'posSummary'     => view('backend.pages.pos.inc.posSummary', compact('carts'))->render(),
                        ];
                        return $responseData;
                    } else {
                        $responseData = [
                            'status'    => false,
                            'message'   => localize('Out of stock'),
                            'carts'     => view('backend.pages.pos.inc.pos-cart', compact('carts'))->render(),
                            'posSummary'     => view('backend.pages.pos.inc.posSummary', compact('carts'))->render(),
                        ];
                        return $responseData;
                    }
                }
            } else {
                // add first item to list
                if ($stock > 0) {
                    $tempCart = new Cart;
                    $tempCart->product_variation_id = $request->product_variation_id;
                    $tempCart->qty = 1;
                    array_unshift($carts, $tempCart);

                    $responseData = [
                        'status'    => true,
                        'message'   => '',
                        'carts'     => view('backend.pages.pos.inc.pos-cart', compact('carts'))->render(),
                        'posSummary'     => view('backend.pages.pos.inc.posSummary', compact('carts'))->render(),
                    ];
                    return $responseData;
                } else {
                    $responseData = [
                        'status'    => false,
                        'message'       => localize('Out of stock'),
                        'carts'          => view('backend.pages.pos.inc.pos-cart', compact('carts'))->render(),
                        'posSummary'     => view('backend.pages.pos.inc.posSummary', compact('carts'))->render(),
                    ];
                    return $responseData;
                }
            }
        }
    }

    # product info
    public function productInfo(Request $request)
    {
        $product = Product::find($request->id);
        return view('backend.pages.pos.inc.variationInfo', ['product' => $product]);
    }

    # delete from cart
    public function deleteFromCart(Request $request)
    {
        $carts = [];

        // old 
        if ($request->product_variation_ids != null) {
            foreach ($request->product_variation_ids as $key => $productVariationId) {
                if ($request->product_variation_id != $productVariationId) {
                    $tempCart = new Cart;
                    $tempCart->product_variation_id = $productVariationId;
                    $tempCart->qty = $request->quantities[$key];
                    array_push($carts, $tempCart);
                }
            }
        }

        return [
            'status'    => true,
            'carts'          => view('backend.pages.pos.inc.pos-cart', compact('carts'))->render(),
            'posSummary'     => view('backend.pages.pos.inc.posSummary', compact('carts'))->render(),
        ];
    }

    # handleQty
    public function handleQty(Request $request)
    {

        $carts = [];
        $message = '';

        if ($request->action == "decrease") {
            // decrease qty
            if ($request->product_variation_ids != null) {
                foreach ($request->product_variation_ids as $key => $productVariationId) {

                    $tempCart = new Cart;
                    $tempCart->product_variation_id = $productVariationId;

                    if ($request->product_variation_id == $productVariationId) {
                        if ($request->quantities[$key] > 1) {
                            $tempCart->qty = $request->quantities[$key] - 1;
                            array_push($carts, $tempCart);
                        }
                    } else {
                        $tempCart = new Cart;
                        $tempCart->product_variation_id = $productVariationId;
                        $tempCart->qty = $request->quantities[$key];
                        array_push($carts, $tempCart);
                    }
                }
            }
        } else {
            // increase qty
            if ($request->product_variation_ids != null) {
                foreach ($request->product_variation_ids as $key => $productVariationId) {

                    $tempCart = new Cart;
                    $tempCart->product_variation_id = $productVariationId;

                    if ($request->product_variation_id == $productVariationId) {
                        // new
                        $productVariation = ProductVariation::where('id', $request->product_variation_id)->first();
                        $productVariationStock = $productVariation->product_variation_stock; // if null, out of stock for this location

                        // stock entry available in system but check qty
                        $stock = $productVariationStock ? $productVariationStock->stock_qty : 0;
                        if ($stock > $request->quantities[$key]) {
                            $tempCart->qty = $request->quantities[$key] + 1;
                            array_push($carts, $tempCart);
                        } else {
                            $message  = localize('No more stock left of this product');
                        }
                    } else {
                        $tempCart = new Cart;
                        $tempCart->product_variation_id = $productVariationId;
                        $tempCart->qty = $request->quantities[$key];
                        array_push($carts, $tempCart);
                    }
                }
            }
        }

        return [
            'status'            => $message == '' ? true : false,
            'carts'             => view('backend.pages.pos.inc.pos-cart', compact('carts'))->render(),
            'posSummary'        => view('backend.pages.pos.inc.posSummary', compact('carts'))->render(),
        ];
    }

    # getVariationId by code
    public function getVariationId(Request $request)
    {
        $productVariation = ProductVariation::where('code', $request->code)->first();
        if (is_null($productVariation)) {
            return [
                'success' => false,
                'message' => localize('Product does not exist by this code')
            ];
        }

        return [
            'success' => true,
            'variation' => $productVariation
        ];
    }

    # updatePosSummary
    public function updatePosSummary(Request $request)
    {
        $carts = [];
        // old 
        if ($request->product_variation_ids != null) {
            foreach ($request->product_variation_ids as $key => $productVariationId) {
                $tempCart = new Cart;
                $tempCart->product_variation_id = $productVariationId;
                $tempCart->qty = $request->quantities[$key];
                array_push($carts, $tempCart);
            }
        }
        $shippingAmount = $request->total_shipping_cost;
        $discountAmount = $request->additional_discount_value;
        $discountTypeOption = $request->additional_discount_type;

        return [
            'status'    => true,
            'posSummary'     => view('backend.pages.pos.inc.posSummary', compact('carts', 'shippingAmount', 'discountAmount', 'discountTypeOption'))->render(),
        ];
    }

    # complete order
    public function completeOrder(Request $request)
    {
        // to convert input price to base price
        if (Session::has('currency_code')) {
            $currency_code = Session::get('currency_code', config('app.currency_code'));
        } else {
            $currency_code = env('DEFAULT_CURRENCY');
        }
        $currentCurrency = \App\Models\Currency::where('code', $currency_code)->first();

        $carts = [];
        // old 
        if ($request->product_variation_ids != null) {
            foreach ($request->product_variation_ids as $key => $productVariationId) {
                $tempCart = new Cart;
                $tempCart->product_variation_id = $productVariationId;
                $tempCart->qty = $request->quantities[$key];
                array_push($carts, $tempCart);
            }
        }

        if (count($carts) > 0) {
            # order group
            $orderGroup = new OrderGroup;
            $orderGroup->user_id                = $request->selected_customer_id;

            if ($request->selected_customer_id != null) {
                $user = User::find((int)$request->selected_customer_id);
                $orderGroup->phone_no     = $user->phone;
            }

            $orderGroup->location_id            = session('stock_location_id');
            $orderGroup->sub_total_amount                   = getSubTotal($carts, false, '', false);
            $orderGroup->total_tax_amount                   = getTotalTax($carts);

            $orderGroup->is_pos_order          = 1;
            $orderGroup->pos_order_address     = $request->selected_customer_address;

            $orderGroup->additional_discount_type                       = $request->additional_discount_type;

            if ($request->additional_discount_type == "flat") {
                $orderGroup->additional_discount_value                  = $request->additional_discount_value / $currentCurrency->rate;
                $orderGroup->total_discount_amount                      = $orderGroup->additional_discount_value;
            } else {
                $orderGroup->additional_discount_value                  = $request->additional_discount_value;

                $discount = ($orderGroup->sub_total_amount + $orderGroup->total_tax_amount * $request->additional_discount_value) / 100;
                $orderGroup->total_discount_amount                      = $discount;
            }

            $orderGroup->total_shipping_cost                = $request->total_shipping_cost / $currentCurrency->rate;
            $orderGroup->grand_total_amount                 = $orderGroup->sub_total_amount + $orderGroup->total_tax_amount + $orderGroup->total_shipping_cost - $orderGroup->total_discount_amount;
            $orderGroup->save();

            # order
            $order = new Order;
            $order->order_group_id  = $orderGroup->id;
            $order->shop_id         = $carts[0]->product_variation->product->shop_id;
            $order->user_id         = $orderGroup->user_id;
            $order->location_id     = session('stock_location_id');
            $order->total_admin_earnings            = $orderGroup->grand_total_amount;
            $order->shipping_cost                   = $orderGroup->total_shipping_cost;
            $order->delivery_status                   = $request->delivery_status;
            $order->payment_status                   = paidPaymentStatus();
            $order->save();

            # order items
            foreach ($carts as $cart) {
                $orderItem                       = new OrderItem;
                $orderItem->order_id             = $order->id;
                $orderItem->product_variation_id = $cart->product_variation_id;
                $orderItem->qty                  = $cart->qty;
                $orderItem->location_id     = session('stock_location_id');
                $orderItem->unit_price           = variationDiscountedPrice($cart->product_variation->product, $cart->product_variation);
                $orderItem->total_tax            = variationTaxAmount($cart->product_variation->product, $cart->product_variation);
                $orderItem->total_price          = $orderItem->unit_price * $orderItem->qty;
                $orderItem->save();

                $product = $cart->product_variation->product;
                $product->total_sale_count += $orderItem->qty;
                // minus stock qty

                try {
                    $productVariationStock = $cart->product_variation->product_variation_stock;
                    $productVariationStock->stock_qty -= $orderItem->qty;
                    $productVariationStock->save();
                } catch (\Throwable $th) {
                    //throw $th;
                }
                $product->stock_qty -= $orderItem->qty;
                $product->save();

                if ($product->categories()->count() > 0) {
                    foreach ($product->categories as $category) {
                        $category->total_sale_count += $orderItem->qty;
                        $category->save();
                    }
                }
            }

            # order group  
            $orderGroup->payment_method = $request->payment;
            if ($request->payment == "card") {
                // store card info
                $tempCardInfo = new OrderUpdate;
                $tempCardInfo->card_owner_name = $request->card_owner_name;
                $tempCardInfo->card_number = $request->card_number;
                $tempCardInfo->expiration = $request->expiration;
                $tempCardInfo->cvv = $request->cvv;

                $orderGroup->payment_details = json_encode($tempCardInfo);
                $orderGroup->save();
            }
            return $order->id;
        } else {
            return [
                'success' => false,
                'message' => localize('Add products to list to make order')
            ];
        }
    }

    # download invoice
    public function downloadInvoice($id)
    {
        if (session()->has('locale')) {
            $language_code = session()->get('locale', config('app.locale'));
        } else {
            $language_code = env('DEFAULT_LANGUAGE');
        }

        if (session()->has('currency_code')) {
            $currency_code = session()->get('currency_code', config('app.currency_code'));
        } else {
            $currency_code = env('DEFAULT_CURRENCY');
        }

        if (Language::where('code', $language_code)->first()->is_rtl == 1) {
            $direction = 'rtl';
            $default_text_align = 'right';
            $reverse_text_align = 'left';
        } else {
            $direction = 'ltr';
            $default_text_align = 'left';
            $reverse_text_align = 'right';
        }

        if ($currency_code == 'BDT' || $language_code == 'bd') {
            # bengali font
            $font_family = "'Hind Siliguri','sans-serif'";
        } elseif ($currency_code == 'KHR' || $language_code == 'kh') {
            # khmer font
            $font_family = "'Khmeros','sans-serif'";
        } elseif ($currency_code == 'AMD') {
            # Armenia font
            $font_family = "'arnamu','sans-serif'";
        } elseif ($currency_code == 'AED' || $currency_code == 'EGP' || $language_code == 'sa' || $currency_code == 'IQD' || $language_code == 'ir') {
            # middle east/arabic font
            $font_family = "'XBRiyaz','sans-serif'";
        } else {
            # general for all
            $font_family = "'Roboto','sans-serif'";
        }

        $order = Order::findOrFail((int)$id);
        return PDF::loadView('backend.pages.orders.invoice', [
            'order' => $order,
            'font_family' => $font_family,
            'direction' => $direction,
            'default_text_align' => $default_text_align,
            'reverse_text_align' => $reverse_text_align
        ], [], [])->stream(getSetting('order_code_prefix') . $order->orderGroup->order_code . '.pdf');
    }
}
