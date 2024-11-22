<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Park;

class ParkController extends Controller
{
    //

    public function enter($id){

        $park = Park::find($id);

        $response = Http::get("http://$park->device_ip . '/enter");
        
        return response()->json([
            'status'=>'entered'
        ],200);
    }
    public function exit($id){
        
        $park = Park::find($id);

        $response = Http::get("http://$park->device_ip . '/exit");

        return response()->json([
            'status'=>'exited'
        ],200);
    }
}
