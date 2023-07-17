<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderGroup;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    # track orders
    public function index(Request $request)
    {

        if ($request->code != null) {
            $searchCode = $request->code;
            $orderGroup = OrderGroup::where('order_code', $searchCode)->first();
            $order = null;

            if (!is_null($orderGroup)) {
                $order = Order::where('user_id', auth()->user()->id)->where('order_group_id', $orderGroup->id)->first();
            }

            if (!is_null($order)) {
                $view = getView('pages.users.orderTrack', ['order' => $order, 'searchCode' => $searchCode]);
            } else {
                flash(localize('No order found by this code'))->error();
                $view = getView('pages.users.orderTrack', ['searchCode' => $searchCode]);
            }
        } else {
            $view = getView('pages.users.orderTrack');
        }

        return $view;
    }
}
