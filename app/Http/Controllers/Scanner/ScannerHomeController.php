<?php

namespace App\Http\Controllers\Scanner;

use App\Http\Controllers\Controller;
use App\Models\Park;
use Illuminate\Http\Request;
use App\Models\ParkReservation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models\ParkPrice;

class ScannerHomeController extends Controller
{
    //
    public function index(){
        return view('scanner.scanner-index');
    }

    public function decodeQr($qr){  

        try {

            $reservation = ParkReservation::with('park')->where('qr_ref', $qr)->first();
            $ngrokUrl = env('NGROK_TUNNEL');
        

            //return $reservation;
            //return $esp8266IpAddress;
           // return $reservation;
           
            if($reservation && $reservation->enter_time == null){
                // return $reservation->park_reservation_id;
                //$response = Http::get("https://native-awake-ewe.ngrok-free.app/enter/$esp8266IpAddress");
                // enter the vehicle on device
                
                //comment for debugging purpose

                Http::get($ngrokUrl. '/enter'. '/'.$reservation->park->park_id);

    
                ParkReservation::where('park_reservation_id', $reservation->park_reservation_id)
                    ->update([
                        'enter_time'=> Carbon::now(),
                        'remarks'=> 'RESERVE',
                    ]);
    
                Park::where('park_id',$reservation->park->park_id)
                    ->update([
                        'is_occupied' => 1,
                    ]);
    
                return response()->json([
                    'status' => 'updated'
                ],200);
            }

        }catch(\Exception $err){

            return response()->json([
                'error' => $err->getMessage()
            ],500);
        }
    }
    
    
}
