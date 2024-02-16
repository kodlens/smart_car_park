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
    public function sendNodemcu(Request $req){
        $client = new Client([
                'base_uri' => 'http://192.168.1.101:80', // Adjust IP address and port
                'timeout'  => 5.0,
            ]);
            $parkId = $req;
            try {
                $response = $client->request('POST', '/send-nodemcu', [
                    'json' => ['park_id' => $parkId],
                    'timeout'  => 5.0,
                ]);
    
                $statusCode = $response->getStatusCode();
                if ($statusCode == 200) {
                    return response()->json(['message' => 'Data sent to NodeMCU successfully'], 200);
                } else {
                    return response()->json(['error' => 'Failed to send data to NodeMCU'], $statusCode);
                }
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

    }

    public function decodeQr($qr){  
        $reservation = ParkReservation::where('qr_ref', $qr)->first();
        if($reservation && !$reservation->enter_time){

            // ParkReservation::where('park_reservation_id',$reservation->park_reservation_id)
            // ->update([
            //     'enter_time'=> Carbon::now(),
            // ]);
            return $reservation;
        }
        elseif($reservation && $reservation->enter_time){
            ParkReservation::where('park_reservation_id',$reservation->park_reservation_id)
            ->update([
                'exit_time'=> Carbon::now(),
            ]);
            Park::where('park_id',$reservation->park_id)
            ->update([
                'is_occupied' => 0,
            ]);
            return $reservation;
        }
        return response()->json([
            'status' => 'failed'
        ],404);
    }
}
