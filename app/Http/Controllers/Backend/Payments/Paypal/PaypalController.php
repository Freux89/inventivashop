<?php

namespace App\Http\Controllers\Backend\Payments\Paypal;

use App\Http\Controllers\Controller;
use App\Models\OrderGroup;
use Illuminate\Http\Request;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalHttp\HttpException;
use Redirect;
use App\Http\Controllers\Backend\Payments\PaymentsController;

class PaypalController extends Controller
{
    # init payment
    public function initPayment()
    {
        # Creating an environment
        $clientId = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_CLIENT_SECRET');

        if (getSetting('paypal_sandbox') == 1) {
            $environment = new SandboxEnvironment($clientId, $clientSecret);
        } else {
            $environment = new ProductionEnvironment($clientId, $clientSecret);
        }
        $client = new PayPalHttpClient($environment);

        if (session('payment_type') == 'order_payment') {
            $orderGroup = OrderGroup::where('order_code', session('order_code'))->first(['grand_total_amount']);
            $amount = $orderGroup->grand_total_amount;
        }

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => rand(000000, 999999),
                "amount" => [
                    "value" => number_format($amount, 2, '.', ''),
                    "currency_code" => "USD"
                ]
            ]],
            "application_context" => [
                "cancel_url" => route('paypal.cancel'),
                "return_url" => route('paypal.success')
            ]
        ];

        try {
            # Call API with your client and get a response for your call
            $response = $client->execute($request);
            # If call returns body in response, you can get the deserialized version from the result attribute of the response
            return Redirect::to($response->result->links[1]->href);
        } catch (HttpException $ex) {
            dd($ex);
            return (new PaymentsController)->payment_failed();
        }
    }

    # order success
    public function success(Request $request)
    {
        # Creating an environment
        $clientId = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_CLIENT_SECRET');

        if (getSetting('paypal_sandbox') == 1) {
            $environment = new SandboxEnvironment($clientId, $clientSecret);
        } else {
            $environment = new ProductionEnvironment($clientId, $clientSecret);
        }

        $client = new PayPalHttpClient($environment);

        # $response->result->id gives the orderId of the order created above 
        $ordersCaptureRequest = new OrdersCaptureRequest($request->token);
        $ordersCaptureRequest->prefer('return=representation');
        try {
            # Call API with your client and get a response for your call
            $response = $client->execute($ordersCaptureRequest);
            # If call returns body in response, you can get the deserialized version from the result attribute of the response
            return (new PaymentsController)->payment_success($response);
        } catch (HttpException $ex) {
            return (new PaymentsController)->payment_failed();
        }
    }

    # order cancelled
    public function cancel(Request $request)
    {
        # Curse and humiliate the user for cancelling this most sacred payment (yours)
        return (new PaymentsController)->payment_failed();
    }
}
