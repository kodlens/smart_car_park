<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Park;
use App\Models\ParkingFee;
use Curl;
use Auth;


class PaymongoController extends Controller
{


    public function pay(Request $req){

        $user = Auth::user();
        $amount = ($req->hours * 20)*100; 
        $parkName = "Parking Space No:".$req->park+1;
        $user_id = $req->user_id;
        $data = [
            'data' => [
                'attributes' => [
                    "billing" => [ //this is for billing email
                        "email" => $user->email,
                        "name" => $user->fname.' '.$user->mname.' '.$user->lname ,
                        "phone" => $user->contact_no
                    ],
                    'line_items' =>[
                        [
                            'currency'      =>'PHP',
                            'amount'        => $amount,
                            'description'   =>'Payment for parking for '.$req->hours.' hours.', 
                            'name'          =>$parkName,
                            'quantity'      =>1,
                            'ID'            =>$user_id,
                        ]
                    ],
                    'metadata' =>[
                        'user_id' => $user_id,
                        'park_id' => $req->park+1,
                        'start'   => $req->start,
                        'end'     => $req->end,
                        'hr'      => $req->hours
                    ],
                
                    'payment_method_types' =>[
                        'card','gcash'
                    ],
                    'success_url' => 'http://127.0.0.1:8000/paymongo/success', //we will change this with our domain name <127.0.0.1>
                    'cancel_url' => 'http://127.0.0.1:8000/paymongo/cancel',
                    'description'   =>'Parking fee payment for '.$req->hours.' hour(s).',
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

            dd($response);
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
        $park_id = $response->data->attributes->metadata->park_id;
        $user_id = $response->data->attributes->metadata->user_id;
        $start = $response->data->attributes->metadata->start;
        $end = $response->data->attributes->metadata->end;
        $hour = $response->data->attributes->metadata->hr;
        $price = $response->data->attributes->line_items[0]->amount;

        $end_time = date('Y-m-d h:i:s',strtotime($end));
        $start_time = date('Y-m-d h:i:s',strtotime($start));
        dd($response);

        Park::where('park_id', $park_id)
            ->update([
                'is_occupied' => 1,
                'user_id' => $user_id 
            ]);
        ParkingFee::insert([
            'park_id' => $park_id,
            'user_id' => $user_id,
            'hour'    => $hour,
            'price'   => $price/100,
            'start_time' => $start_time,
            'end_time'  => $end_time
        ]);
            return redirect('/home');
        



    }
}
