<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Strand;
use Illuminate\Http\Request;
use App\Models\StrandCourse;

class StrandController extends Controller
{
    //

    public function index(){
        return view('administrator.strand.strand-page');
    }

    public function getStrands(Request $req){

        $sort = explode('.', $req->sort_by);

        $data = Strand::with(['track', 'courses.course'])
            ->where('strand', 'like', $req->strand . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function show($id){
        $data = Strand::find($id);
        return $data;
    }

    public function store(Request $req){
        $req->validate([
            'track_id' => ['required'],
            'strand' => ['required', 'unique:strands']
        ]);

        Strand::create([
            'track_id' => $req->track_id,
            'strand' => strtoupper($req->strand),
            'strand_desc' => strtoupper($req->strand_desc),
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }


    public function update(Request $req, $id){

        $req->validate([
            'track_id' => ['required'],
            'strand' => ['required', 'unique:strands,strand,' .$id.',strand_id']
        ]);

        $data = Strand::find($id);
        $data->track_id = $req->track_id;
        $data->strand = strtoupper($req->strand);
        $data->strand_desc = strtoupper($req->strand_desc);
        $data->save();

        return response()->json([
            'status' => 'updated'
        ], 200);
    }



    public function destroy($id){
        Strand::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);
    }








    public function addCourse(Request $req){

        $req->validate([
            'strand_id' => ['required'],
            'course_id' => ['required'],
        ]);
        StrandCourse::create([
            'strand_id' => $req->strand_id,
            'course_id' => $req->course_id,
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }


}
