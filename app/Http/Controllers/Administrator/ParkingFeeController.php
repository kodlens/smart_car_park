<?php

namespace App\Http\Controllers\Administrator;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParkPrice;

class ParkingFeeController extends Controller
{
    //

    public function index(){
        return view('administrator.parkinfee.parking-fee');
    }

    public function show($id){
        return ParkPrice::find($id);
    }
    public function getData(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = ParkPrice::paginate($req->perpage);

        return $data;
    }

    // public function store(Request $req){
    //     $req->validate([
    //         'parking_hour' => ['required', 'unique:parking_fees'],
    //         'parking_price' => ['required'],

    //     ]);

    //     ParkReservation::create([
    //         'parking_hour' => $req->parking_hour,
    //         'parking_price' => $req->parking_price,
    //     ]);

    //     return response()->json([
    //         'status' => 'saved'
    //     ], 200);
    // }


    
    public function update(Request $req, $id){
        $req->validate([
            'park_price' => ['required']
        ]);
        ParkPrice::where('id', $id)
            ->update([
                'park_price' => $req->park_price
            ]);

        return response()->json([
            'status' => 'updated'
        ], 200);
    }



}
