<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Curl;


class PaymongoController extends Controller
{
    public function pay(){
        $data = [
            'data' => [
                'attributes' => [
                    'line_items' =>[
                        [
                            'currency'      =>'PHP',
                            'amount'        =>2000,
                            'description'   =>'text', 
                            'name'          =>'Test Product',
                            'quantity'      =>1,
                        ]
                    ],
                

                'payment_method_types' =>[
                    'card','gcash'
                ],
                'success_url' => 'http://127.0.0.1:8000/success',
                'cancel_url' => 'http://127.0.0.1:8000/success',
                'description'   =>'text'
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

                // dd($response);
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

                dd($response);
    }
}
