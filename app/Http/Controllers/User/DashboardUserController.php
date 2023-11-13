<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admit;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardUserController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
        //$this->middleware('user');
    }

    public function index(){
        return view('user.user-dashboard');
    }

    public function getUser(){
        return Auth::user();
    }

    public function getDashboardInfo(){
        $admit = Admit::count();
        $appointment = Appointment::count();
        $user = User::count();
        return response()->json([
            'admit' => $admit,
            'appointment' => $appointment,
            'user' => $user
        ]);
    }



}
