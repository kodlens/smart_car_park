<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParkReservation;

class MyReservationController extends Controller
{
    //


    public function index(){
        return view('user.my-reservation');
    }



    public function getData(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = ParkReservation::with(['park', 'user'])
            ->where('qr_ref', 'like', $req->qrref . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }


}
