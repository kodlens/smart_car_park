<?php

namespace App\Http\Controllers\Scanner;

use App\Http\Controllers\Controller;
use App\Models\Park;
use Illuminate\Http\Request;
use App\Models\ParkReservation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class ScannerHomeController extends Controller
{
    //
    public function index(){
        return view('scanner.scanner-index');
    }

    public function decodeQr($qr){  

        try {
            $reservation = ParkReservation::with('park')->where('qr_ref', $qr)->first();
            $esp8266IpAddress = $reservation->park->device_ip;
    
            //return $reservation;
    
            //return $esp8266IpAddress;
    
           // return $reservation;
            if($reservation && $reservation->enter_time == null){
                // return $reservation->park_reservation_id;
                //$response = Http::get("https://native-awake-ewe.ngrok-free.app/enter/$esp8266IpAddress");
                // enter the vehicle on device
                
                //comment for debugging purpose
                $res = Http::get("http://".$esp8266IpAddress."/enter");

    
                ParkReservation::where('park_reservation_id', $reservation->park_reservation_id)
                    ->update([
                        'enter_time'=> Carbon::now(),
                        'remarks'=> 'RESERVE',
                    ]);
    
                Park::where('park_id',$reservation->park_id)
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
    
    public function exitPark($id){
        $reservation = ParkReservation::with('park')->where('park_reservation_id', $id)->latest()->first();
        $esp8266IpAddress = $reservation->park->device_ip;
        if($reservation && $reservation->enter_time){
            //$response = Http::get("https://native-awake-ewe.ngrok-free.app/exit/$esp8266IpAddress");
            ParkReservation::where('park_reservation_id',$reservation->park_reservation_id)
            ->update([
                'exit_time'=> Carbon::now(),
            ]);
            Park::where('park_id',$reservation->park_id)
                ->update([
                    'is_occupied' => 0,
                ]);
            //exit the vehicle on device
            
            //comment for debugging
            Http::get("http://".$esp8266IpAddress."/exit");

            return response()->json([
                'status' => 'updated'
            ],200);
        }
        return response()->json([
            'status' => 'failed'
        ],404);
        
    }
}
