<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkingFee;
use App\Models\Park;
use Auth;

class ParkReservationController extends Controller
{
    public function loadParkReservation(Request $req){
        $park = ParkingFee::where('park_id', $req->park_id)
        ->orderByDesc('park_reservation_id')
        ->first();

        return $park;
        
    }

    public function enterPark(){
        $now = now();

    }

    public function exitPark(Request $req){
        $req->validate([
            'park_id'=> ['required'],
        ]);
        $now = now();
        $exit_time = date('Y-m-d H:i:s',strtotime($now));
        Park::where('park_id', $req->park_id+1)
            ->update([
                'is_occupied' => 0,
                'user_id' => 0,
            ]);
        return response()->json([
            'status' => 'updated'
        ], 200);
    }
}
