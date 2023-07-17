<?php

namespace App\Http\Controllers\Backend\Payments\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderGroup;
use Stripe\Stripe;
use App\Http\Controllers\Backend\Payments\PaymentsController;

class StripePaymentController extends Controller
{
    # stripe payment view
    public function initPayment()
    {
        return view('payments.stripe');
    }

    # init payment
    public function checkoutSession()
    {
        $amount = 0;
        if (session('payment_type') == 'order_payment') {
            $orderGroup = OrderGroup::where('order_code', session('order_code'))->first(['grand_total_amount']);
            $amount = round($orderGroup->grand_total_amount * 100);
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => "USD",
                        'product_data' => [
                            'name' => "Payment"
                        ],
                        'unit_amount' => $amount,
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url' => route('stripe.cancel'),
        ]);
        return response()->json(['id' => $session->id, 'status' => 200]);
    }

    # successful payment
    public function success()
    {
        try {
            $payment = ["status" => "Success"];
            $payment_type = session('payment_type');
            if ($payment_type == 'order_payment') {
                return (new PaymentsController)->payment_success(json_encode($payment));
            }
        } catch (\Exception $e) {
            return (new PaymentsController)->payment_failed();
        }
    }

    # cancelled
    public function cancel()
    {
        return (new PaymentsController)->payment_failed();
    }
}
