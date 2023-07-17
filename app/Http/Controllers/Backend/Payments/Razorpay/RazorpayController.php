<?php

namespace App\Http\Controllers\Backend\Payments\Razorpay;

use App\Http\Controllers\Backend\Payments\PaymentsController;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\OrderGroup;

class RazorpayController extends Controller
{

    # init payment
    public function initPayment()
    {
        $user = auth()->user();
        $payment_type = session('payment_type');
        switch ($payment_type) {
            case 'order_payment':
                $title = localize('Order Payment');
                $orderGroup = OrderGroup::where('order_code', session('order_code'))->first();
                $amount = $orderGroup->grand_total_amount;
                break;
            default:
                $title = '';
                $amount = 0;
        }

        $data = [
            'amount' => $amount * 100,
            'name' => $user->name,
            'email' => $user->email,
            'app_name' => env('APP_NAME'),
            'app_logo' => uploadedAsset(getSetting('navbar_logo')),
            'payment_title' => $title
        ];
        return view('payments.razorpay', compact('data'));
    }


    # make payment
    public function payment(Request $request)
    {
        //Input items of form
        $input = $request->all();
        //get API Configuration
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if (count($input)  && !empty($input['razorpay_payment_id'])) {
            $payment_details = null;
            try {

                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));
                $payment_details = json_encode(array(
                    'id' => $response['id'],
                    'method' => $response['method'],
                    'amount' => $response['amount'],
                    'currency' => $response['currency']
                ));
            } catch (\Exception $e) {
                return (new PaymentsController)->payment_failed();
            }

            if (session('payment_type') == 'order_payment') {
                return (new PaymentsController)->payment_success(json_encode($payment_details));
            }
        }
    }
}
