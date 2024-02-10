<?php

namespace App\Http\Controllers\Administrator;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParkReservation;

class ParkingFeeController extends Controller
{
    //

    public function index(){
        return view('administrator.parkinfee.parking-fee');
    }

    public function show($id){
        return ParkReservation::find($id);
    }
    public function getData(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = ParkReservation::where('parking_hour', 'like', $req->park . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function store(Request $req){
        $req->validate([
            'parking_hour' => ['required', 'unique:parking_fees'],
            'parking_price' => ['required'],

        ]);

        ParkReservation::create([
            'parking_hour' => $req->parking_hour,
            'parking_price' => $req->parking_price,
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }


    
    public function update(Request $req, $id){
        $req->validate([
            'parking_hour' => ['required', 'unique:parking_fees,parking_hour,' . $id . ',parking_fee_id'],
            'parking_price' => ['required'],

        ]);
        ParkReservation::where('parking_fee_id', $id)
            ->update([
                'parking_hour' => $req->parking_hour,
                'parking_price' => $req->parking_price,
            ]);

        return response()->json([
            'status' => 'updated'
        ], 200);
    }



}
