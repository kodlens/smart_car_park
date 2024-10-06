<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParkPrice;

class HomeController extends Controller
{
    //

    
    public function index(){
        $parkPrice = ParkPrice::first();
        return view('user.home-page')
            ->with('parkPrice', $parkPrice);
    }
    

  
}
