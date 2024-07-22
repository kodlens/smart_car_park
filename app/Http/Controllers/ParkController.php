<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ParkController extends Controller
{
    //

    public function enter($ip){
        $esp8266IpAddress = $ip;
        $response = Http::get("http://$esp8266IpAddress/enter");
        
        return response()->json([
            'status'=>'entered'
        ],200);
    }
    public function exit($ip){
        $esp8266IpAddress = $ip;
        $response = Http::get("http://$esp8266IpAddress/exit");

        return response()->json([
            'status'=>'exited'
        ],200);
    }
}
