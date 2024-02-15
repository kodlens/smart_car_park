<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkReservation;
use App\Models\Park;
use Auth;

class ParkReservationController extends Controller
{
    public function loadParkReservation(){
        $id = Auth::user()->user_id;
        $park = ParkReservation::where('user_id',$id)
        ->whereNull('exit_time')
        ->get();

        return $park;     
    }

}
