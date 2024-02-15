<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Park;


class ParkingSpacesController extends Controller
{
    //


    public function loadParkingSpaces(Request $req){
        $parkingSpace =  Park::with(['parkReservation' => function ($query) {
            $query->latest('created_at');
        }])->get()
        ->map(function ($park) {
            $latestReservation = $park->parkReservation->first(); // Get the latest reservation for each park
            $park->setAttribute('parkReservation', $latestReservation); // Replace parkReservation with the latest one
            return $park;
        });
        return $parkingSpace;
    }    

}
