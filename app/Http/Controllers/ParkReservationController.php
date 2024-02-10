<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkReservation;
use App\Models\Park;
use Auth;

class ParkReservationController extends Controller
{
    public function loadParkReservation(Request $req){
        $park = ParkReservation::where('park_id', $req->park_id+1)
        ->orderByDesc('park_reservation_id')
        ->first();

        return $park;     
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
            ]);

        ParkReservation::where('park_reservation_id',$req->park_reservation_id)
        ->update(
            [
                'exit_time' =>  $exit_time
            ]);
        return response()->json([
            'status' => 'updated'
        ], 200);
    }

    public function enterPark(Request $req){
        $req->validate([
            'park_id'=> ['required'],
        ]);
        $now = now();
        $enter_time = date('Y-m-d H:i:s',strtotime($now));

        ParkReservation::where('park_reservation_id',$req->park_reservation_id)
        ->update(
            [
                'enter_time' =>  $enter_time
            ]);
        return response()->json([
            'status' => 'updated'
        ], 200);
    }
}
