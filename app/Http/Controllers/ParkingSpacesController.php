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

}
