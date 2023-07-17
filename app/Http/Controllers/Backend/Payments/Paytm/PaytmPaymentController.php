<?php

namespace App\Http\Controllers\Backend\Payments\Paytm;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\Payments\PaymentsController;
use App\Models\OrderGroup;
use App\Models\User;
use PaytmWallet;

class PaytmPaymentController extends Controller
{
    # paytm init payment
    public function initPayment()
    {
        $user = User::find(auth()->user()->id);
        if (session('payment_type') == 'order_payment') {
            $orderGroup = OrderGroup::where('order_code', session('order_code'))->first();
            $amount = $orderGroup->grand_total_amount;

            $payment = PaytmWallet::with('receive');
            $payment->prepare([
                'order' => $orderGroup->id,
                'user' => $user->id,
                'mobile_number' => $user->phone != null ? $user->phone : "+912354123123",
                'email' => $user->email != null ? $user->email : "customer@example.com",
                'amount' => $amount,
                'callback_url' => route('paytm.callback')
            ]);
            return $payment->receive();
        }
    }

    # paytm callback
    public function callback()
    {
        $transaction = PaytmWallet::with('receive');
        $response = $transaction->response(); // To get raw response as array
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm

        if ($transaction->isSuccessful()) {
            if (session('payment_type') == 'order_payment') {
                return (new PaymentsController)->payment_success(json_encode($response));
            }
        } elseif ($transaction->isFailed()) {
            return (new PaymentsController)->payment_failed();
        }
    }
}
