<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Park;

class ParkController extends Controller
{
    public function index(){
        return view('administrator.park-device.park-devices');
    }

    public function getData(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = Park::where('name', 'like', $req->search . '%')
            ->paginate($req->perpage);

        return $data;
    }


    public function show($id){
        return Park::find($id);
    }

    public function store(Request $req){ 
        $req->validate([
            'name' => ['required'],
            'device_ip' => ['required']
        ]);

        Park::create([
            'name' => strtoupper($req->name),
            'device_ip' => $req->device_ip,
            'is_occupied' => $req->is_occupied
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }

    public function update(Request $req, $id){
        $req->validate([
            'name' => ['required'],
            'device_ip' => ['required']
        ]);
        Park::where('park_id', $id)
            ->update([
                'name' => strtoupper($req->name),
                'device_ip' => $req->device_ip,
                'is_occupied' => $req->is_occupied
            ]);

        return response()->json([
            'status' => 'updated'
        ], 200);
    }


    public function destroy($id){
        Park::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);
    }
}
