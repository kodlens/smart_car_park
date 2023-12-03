<?php

namespace App\Http\Controllers\Administrator;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParkingFeeController extends Controller
{
    //

    public function index(){
        return view('administrator.parkinfee.parking-fee');
    }

    
    public function getData(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = ParkingFee::where('parking_hour', 'like', $req->hour . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }


}
