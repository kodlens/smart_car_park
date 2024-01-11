<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Import the class namespaces first, before using it directly
use Srmklive\PayPal\Services\PayPal as PayPalClient;





class PaypalController extends Controller
{
    //

    public function index(){
        return view('test-paypal');
    }


    public function payment(Request $req){
        //return $req;

        $provider = new PayPalClient;

        // Through facade. No need to import namespaces
        $provider = \PayPal::setProvider(config('paypal'));

        $paypalToken = $provider->getAccessToken();

        // $response = $provider->createOrder([
        //     'intent' => 'CAPTURE',
        //     'application_context' => [
        //         'return_url' => route('paypal_success'),
        //         'cancel_url' => route('paypal_cancel')
        //     ],
        //     'purchase_units' => [
        //         'amount' => [
        //             'currency_code' => 'USD',
        //             'value' => $req->price
        //         ]
        //     ]
        // ]);

        $data = json_decode('{
            "intent": "CAPTURE",
            "purchase_units": [
              {
                "amount": {
                  "currency_code": "USD",
                  "value": '.$req->price.'
                }
              }
            ]
        }', true);

        $response = $provider->createOrder($data);


        if(isset($response['id']) && $response['id'] != null){
            foreach($response['links'] as $link){
                if($link['rel'] === 'approve'){
                    return redirect()->away($link['href']);
                }
            }
        }else{
            return redirect()->route('paypal_cancel');        
        }
    }

    public function success(Request $req){
        $provider = new PayPalClient;
        // Through facade. No need to import namespaces
        $provider = \PayPal::setProvider(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($req->token);


        //check response to play with API
        if(isset($response['status']) && $response['status'] == 'COMPLETED'){
            return "Payment successful";
        }else{
            return redirect()->route('paypal_cancel');
        }
    }

    public function cancel(Request $req){
        return "Payment cancelled.";
    }


}
