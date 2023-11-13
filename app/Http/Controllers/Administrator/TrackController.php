<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Track;


class TrackController extends Controller
{
    //

    public function index(){
        return view('administrator.track.track');
    }

    public function getTracks(Request $req){

        $sort = explode('.', $req->sort_by);

        $data = Track::where('track', 'like', $req->track . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function show($id){
        $data = Track::find($id);
        return $data;
    }

    public function store(Request $req){
        $req->validate([
            'track' => ['required', 'unique:tracks']
        ]);

        Track::create([
            'track' => strtoupper($req->track),
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }


    public function update(Request $req, $id){
       
        $req->validate([
            'track' => ['required', 'unique:tracks,track,' .$id.',track_id']
        ]);

        $data = Track::find($id);
        $data->track = strtoupper($req->track);
        $data->save();

        return response()->json([
            'status' => 'updated'
        ], 200);
    }



    public function destroy($id){
        Track::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);
    }
}
