<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Park;


class ParkingSpacesController extends Controller
{
    //


    public function loadParkingSpaces(Request $req){
        return Park::all();
    }

    public function exitPark(Request $req){
        $req->validate([
            'park_id'=> ['required'],
        ]);

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
