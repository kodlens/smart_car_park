<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyReservationController extends Controller
{
    //


    public function index(){
        return view('user.my-reservation');
    }



    public function getData(){
        
    }
}
