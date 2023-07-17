<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Refund;
use Illuminate\Http\Request;

class RefundsController extends Controller
{
    public function refunds()
    {
        if (getSetting('enable_refund_system') == 0) {
            flash(localize('The page you are looking for is not available'))->info();
            return redirect()->route('customers.dashboard');
        }
        $refunds = auth()->user()->refunds()->latest()->paginate(paginationNumber());
        return getView('pages.users.refunds', ['refunds' => $refunds]);
    }
    # submit refund request
    public function store(Request $request)
    {
        $orderItem = OrderItem::where('id', $request->order_item_id)->first();

        $refund = new Refund;
        $refund->user_id = auth()->user()->id;
        $refund->order_group_id = $orderItem->order->orderGroup->id;
        $refund->order_item_id  = $orderItem->id;

        $product = $orderItem->product_variation->product;
        $refund->product_id  = $product->id;

        $refund->order_payment_status  = $orderItem->order->orderGroup->payment_status;
        $refund->refund_reason  = $request->refund_reason;
        $refund->save();

        flash(localize('Refund request has been submitted'))->success();
        return back();
    }
}
