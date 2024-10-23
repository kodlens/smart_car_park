<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyChangePasswordController extends Controller
{
    public function index(){
        return view('user.my-change-password');
    }

    public function changePassword(Request $req){

    }
}
