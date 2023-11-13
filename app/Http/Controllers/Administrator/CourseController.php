<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;


class CourseController extends Controller
{
    //

    public function index(){
        return view('administrator.course.course-index');
    }


    public function getCourses(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = Course::where('course_code', 'like', '%'.$req->course . '%')
            ->orWhere('course_desc', 'like', '%' . $req->course . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);
        return $data;
    }

    public function getBrowseCourses(Request $req){
        $sort = explode('.', $req->sort_by);
        $data = Course::where('course_code', 'like', '%'.$req->code . '%')
            ->orWhere('course_desc', 'like', '%' . $req->course . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);
        return $data;
    }



    public function show($id){
        return Course::find($id);
    }


    public function store(Request $req){
        $req->validate([
            'course_code' => ['required', 'unique:courses'],
            'course_desc' => ['required'],
        ]);

        Course::create([
            'course_code' => strtoupper($req->course_code),
            'course_desc' => strtoupper($req->course_desc),
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }


    public function update(Request $req, $id){
        $req->validate([
            'course_code' => ['required', 'unique:courses,course_code,'. $id . ',course_id'],
            'course_desc' => ['required'],
        ]);

        $data = Course::find($id);
        $data->course_code = strtoupper($req->course_code);
        $data->course_desc = strtoupper($req->course_desc);
        $data->save();

        return response()->json([
            'status' => 'updated'
        ], 200);
    }


    public function destroy($id){
        Course::destroy($id);
        return response()->json([
            'status' => 'deleted'
        ], 200);
    }
}
