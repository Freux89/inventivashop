<?php

namespace App\Http\Controllers\Backend\Refunds;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use App\Models\RewardPoint;
use App\Models\WalletHistory;
use Illuminate\Http\Request;

class RefundsController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:refund_configurations'])->only('configurations');
        $this->middleware(['permission:refund_requests'])->only('requests');
        $this->middleware(['permission:approved_refunds'])->only('refunded');
        $this->middleware(['permission:rejected_refunds'])->only('rejected');
    }

    # refund configuration
    public function configurations()
    {
        return view('backend.pages.refunds.configurations');
    }

    # refund requests
    public function requests()
    {
        $refundRequests = Refund::where('refund_status', "pending")->latest();
        $refundRequests = $refundRequests->paginate(paginationNumber());
        return view('backend.pages.refunds.requests', compact('refundRequests'));
    }

    # approve
    public function approve($id)
    {
        $refund = Refund::find($id);
        $refund->refund_status = "refunded";

        $orderItem = $refund->orderItem;
        $orderItem->is_refunded = 1;
        $orderItem->save();

        $order = $orderItem->order;
        $order->total_admin_earnings -= $orderItem->total_price;
        $order->reward_points -= $orderItem->reward_points;
        $order->save();

        $orderGroup = $order->orderGroup;
        $orderGroup->sub_total_amount -= $orderItem->total_price;
        $orderGroup->grand_total_amount -= $orderItem->total_price;
        $orderGroup->total_tax_amount -= $orderItem->total_tax;
        $orderGroup->save();

        $rewardPoint = RewardPoint::where('order_group_id', $orderGroup->id)->first();
        if (!is_null($rewardPoint)) {
            $rewardPoint->total_points -= $orderItem->reward_points;
            $rewardPoint->save();
        }

        if ($orderGroup->payment_status == paidPaymentStatus()) {
            $user = $orderGroup->user;
            $user->user_balance += $orderItem->total_price;

            $wallet = new WalletHistory;
            $wallet->user_id = $user->id;
            $wallet->amount = $orderItem->total_price;
            $wallet->payment_method = "Refunded Product";

            $wallet->save();
            $user->save();
        }

        $refund->save();
        flash(localize('Product has been successfully refunded'))->success();
        return back();
    }

    # reject
    public function reject(Request $request, $id)
    {
        $refund = Refund::find($id);
        $refund->refund_reject_reason = $request->refund_reject_reason;
        $refund->refund_status = "rejected";
        $refund->save();

        flash(localize('Refund request rejected'))->success();
        return redirect()->route('admin.refund.requests');
    }

    # refunded
    public function refunded()
    {
        $refundRequests = Refund::where('refund_status', "refunded")->latest();
        $refundRequests = $refundRequests->paginate(paginationNumber());
        return view('backend.pages.refunds.refunded', compact('refundRequests'));
    }

    # rejected
    public function rejected()
    {
        $refundRequests = Refund::where('refund_status', "rejected")->latest();
        $refundRequests = $refundRequests->paginate(paginationNumber());
        return view('backend.pages.refunds.rejected', compact('refundRequests'));
    }
}
