<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl;

class PaymongoController extends Controller
{
    public function pay(Request $req){

        $data = [
            'data' => [
                'attributes' => [
                    "billing" => [ //this is for billing email
                        "email" => "etiennewayne@gmail.com",
                        "name" => "Etienne Wayne",
                        "phone" => "09167789585"
                    ],
                    'line_items' =>[
                        [
                            'currency'      =>'PHP',
                            'amount'        => 4000,
                            'description'   =>'text', 
                            'name'          =>'Park Fee',
                            'quantity'      =>1,
                        ]
                    ],
                
                    'payment_method_types' =>[
                        'card','gcash'
                    ],
                    'success_url' => 'http://127.0.0.1:8000/paymongo/success', //we will change this with our domain name <127.0.0.1>
                    'cancel_url' => 'http://127.0.0.1:8000/paymongo/cancel',
                    'description'   =>'Payment for parking fee.',
                    'send_email_receipt' => true //set true
                ],
            ]
        ];
        
        $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions')
            ->withHeader('Content-Type: application/json')
            ->withHeader('accept: application/json')
            ->withHeader('Authorization: Basic '.env('AUTH_PAY'))
            ->withData($data)
            ->asJson()
            ->post();

            //dd($response);
            \Session::put('session_id',$response->data->id);

            return redirect()->to($response->data->attributes->checkout_url);
        
    }


    public function success(){

        $sessionID = \Session::get('session_id');

        $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions/'.$sessionID)
            ->withHeader('accept: application/json')
            ->withHeader('Authorization: Basic '.env('AUTH_PAY'))
            ->asJson()
            ->get();

        return $response;

        

        //dd($response);
    }
}
