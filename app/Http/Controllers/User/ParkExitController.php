<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParkReservation;
use App\Models\ParkPrice;
use Carbon\Carbon;
use Auth;
use Curl;
use App\Models\Park;
use App\Models\ParkSale;


class ParkExitController extends Controller
{

    public function exitPark($id){
        $reservation = ParkReservation::with('park')->find($id);
        $parkPrice = ParkPrice::first()->park_price;
    
        $esp8266IpAddress = $reservation->park->device_ip;

        if($reservation && $reservation->enter_time){
            //$response = Http::get("https://native-awake-ewe.ngrok-free.app/exit/$esp8266IpAddress");
            $endTime = Carbon::parse($reservation->end_time); // Convert end_time to a Carbon instance
            // Get the current time
            $currentTime = Carbon::now();
            // Calculate the difference in hours
            $minutesExcess = $currentTime->diffInMinutes($endTime, false); // `false` indicates we want a negative difference if the current time is before the end time
            $hoursExcess = $minutesExcess / 60;

            
            $roundedHours = ceil($hoursExcess);

            if ($minutesExcess < 0) {
                  // Round up to the nearest whole number
                $fines = $roundedHours * $parkPrice;
                // Display the result (you can format this message as needed)
                //return "The current time is {$roundedHours} hours past the scheduled end time. A fine of {$fines} pesos must be paid before exiting.";
                return response()->json([
                    'status' => 'penalty'
                ], 200);
            }else{
                $currentTime = Carbon::now();
                $reservation->exit_time = $currentTime;
                $reservation->save();

                Park::where('park_id',$park_id)
                    ->update([
                        'is_occupied' => 0,
                    ]);
                    //exit the vehicle on device
                

                if(env('ESP_DEBUG') == 0){
                    Http::get("http://".$esp8266IpAddress."/exit");
                }
        
                return response()->json([
                    'status' => 'updated'
                ], 200);
            }
        }
        return response()->json([
            'status' => 'failed'
        ],404);
        
    }

    
    public function paymongoExitPark($id){

        $reservation = ParkReservation::with('park')->find($id);
        $parkPrice = ParkPrice::first()->park_price;
    
        $esp8266IpAddress = $reservation->park->device_ip;

        if($reservation && $reservation->enter_time){
            //$response = Http::get("https://native-awake-ewe.ngrok-free.app/exit/$esp8266IpAddress");
            $endTime = Carbon::parse($reservation->end_time); // Convert end_time to a Carbon instance
            // Get the current time
            $currentTime = Carbon::now();
            // Calculate the difference in hours
            $minutesExcess = $currentTime->diffInMinutes($endTime, true); // `false` indicates we want a negative difference if the current time is before the end time
            $hoursExcess = $minutesExcess / 60;

            if ($hoursExcess > 0) {
                $roundedHours = ceil($hoursExcess);  // Round up to the nearest whole number

                $fines = $roundedHours * $parkPrice;
            
                // Display the result (you can format this message as needed)
                //return "The current time is {$roundedHours} hours past the scheduled end time. A fine of {$fines} pesos must be paid before exiting.";

                $price = ParkPrice::first();

                $port = request()->getPort();
                $hostWithPort = request()->getScheme() . '://'. request()->getHost() . ($port ? ':' . $port : '');
                //$fullUrl = request()->getScheme() . '://' . request()->getHost() . ':' . request()->getPort();
                $user = Auth::user();

                $amount = ($fines)*100; 
                $parkName = "Parking Name:".$reservation->park->name;
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
                                    'description'   =>'Penalty payment for '.$roundedHours.' hours.', 
                                    'name'          =>$parkName,
                                    'quantity'      =>1,
                                    'ID'            =>$user->user_id,
                                ]
                            ],
                            'metadata' =>[
                                'user_id' => $user->user_id,
                                'park_id' => $reservation->park->park_id,
                                // 'start'   => $req->start,
                                // 'end'     => $req->end,
                                'reservation_id' => $reservation->park_reservation_id,
                                'hr'      => $roundedHours
                            ],
                        
                            'payment_method_types' =>[
                                'card','gcash'
                            ],
                            'success_url' => $hostWithPort .'/paymongo/exit-success', //we will change this with our domain name <127.0.0.1>
                            'cancel_url' =>  $hostWithPort. '/paymongo/exit-cancel',
                            'description'   =>'Penalty payment fee for '.$roundedHours.' hour(s).',
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
                    // dd($response);
                    \Session::put('session_id',$response->data->id);

                    return redirect()->to($response->data->attributes->checkout_url);
                
            }
        }
        return response()->json([
            'status' => 'failed'
        ],404);
        
    }


    public function exitSuccess(){
        $sessionID = \Session::get('session_id');

        $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions/'.$sessionID)
            ->withHeader('accept: application/json')
            ->withHeader('Authorization: Basic '.env('AUTH_PAY'))
            ->asJson()
            ->get();

             //return $response;
        $park_id = $response->data->attributes->metadata->park_id;
        $user_id = $response->data->attributes->metadata->user_id;
        $reservation_id = $response->data->attributes->metadata->reservation_id;
        $hour = $response->data->attributes->metadata->hr;
        $price = ($response->data->attributes->line_items[0]->amount)/100;

 
        $data = ParkReservation::find($reservation_id);
        $currentTime = Carbon::now();
        $data->exit_time = $currentTime;
        $data->save();

        Park::where('park_id',$park_id)
            ->update([
                'is_occupied' => 0,
            ]);
            //exit the vehicle on device

        ParkSale::create([
            'remarks' => 'penalty',
            'user_id' => $user_id,
            'park_id' => $park_id,
            'park_reservation_id' => $reservation_id,
            'price'   => $price,
            'transaction_date' => date('Y-m-d')
        ]);
        
        //return $response;
            //comment for debugging
        if(env('ESP_DEBUG') == 0){
            Http::get("http://".$esp8266IpAddress."/exit");
        }

        return redirect('/home');
    }

    public function exitCancelIndex(){
        return view('paymong.park.cancel-index');
    }
}
