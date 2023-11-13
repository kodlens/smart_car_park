<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StrandCourse;

class StrandCourseController extends Controller
{
    //




    public function destroy($id){
        StrandCourse::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);
    }


}
