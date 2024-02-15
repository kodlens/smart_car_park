<?php

namespace App\Http\Controllers\Scanner;

use App\Http\Controllers\Controller;
use App\Models\Park;
use Illuminate\Http\Request;
use App\Models\ParkReservation;
use Illuminate\Support\Carbon;

class ScannerHomeController extends Controller
{
    //
    public function index(){
        return view('scanner.scanner-index');
    }
    public function decodeQr($qr){
        $reservation = ParkReservation::where('qr_ref', $qr)->first();
        if($reservation && !$reservation->enter_time){
            ParkReservation::where('park_reservation_id',$reservation->park_reservation_id)
            ->update([
                'enter_time'=> Carbon::now(),
            ]);
            return response()->json([
                'status' => 'updated'
            ],200);
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
            return response()->json([
                'status' => 'updated'
            ],200);
        }
        return response()->json([
            'status' => 'failed'
        ],404);
    }
}
