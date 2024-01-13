<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkingFee;
use Auth;

class ParkReservationController extends Controller
{
    public function loadParkReservation(){
        $user_id = Auth::user()->user_id;
        ParkingFee::where('user_id',$user_id);
        return 0;
    }
}
