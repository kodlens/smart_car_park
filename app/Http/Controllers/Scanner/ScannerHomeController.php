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
        $reservation = ParkReservation::with('park')->where('qr_ref', $qr)->first();
        $esp8266IpAddress = $reservation->park->device_ip;
        if($reservation && !$reservation->enter_time){
            $response = Http::get("https://393e-103-168-39-22.ngrok-free.app/enter/$esp8266IpAddress");
            ParkReservation::where('park_reservation_id',$reservation->park_reservation_id)
            ->update([
                'enter_time'=> Carbon::now(),
            ]);
            return response()->json([
                'status' => 'updated'
            ],200);


        }
        elseif($reservation && $reservation->enter_time){
            $response = Http::get("https://393e-103-168-39-22.ngrok-free.app/exit/$esp8266IpAddress");
            ParkReservation::where('park_reservation_id',$reservation->park_reservation_id)
            ->update([
                'exit_time'=> Carbon::now(),
            ]);
            Park::where('park_id',$reservation->park_id)
            ->update([
                'is_occupied' => 0,
            ]);
            return response()->json([
                'status' => 'updated'
            ],200);
        }
        return response()->json([
            'status' => 'failed'
        ],404);
    }
}
