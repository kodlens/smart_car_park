<?php

namespace App\Http\Controllers\Administrator;
use App\Http\Controllers\Controller;
use App\Models\Enrol;

use Illuminate\Http\Request;

class EnrolleeController extends Controller
{

    public function index(){
        return view('administrator.enrollee.enrollee-page');
    }
    public function getEnrollees(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = Enrol::with(['academic_year', 'learner', 'semester', 'track', 'strand', 'section'])
            ->whereHas('academic_year', function($q) use ($req){
                $q->where('academic_year_id', 'like', '%' . $req->ay . '%');
            })
            ->whereHas('learner', function($q) use ($req){
                $q->where('lname', 'like', '%' . $req->name . '%')
                    ->orWhere('fname', 'like', '%' . $req->name . '%');
            })
            ->where('grade_level', 'like', $req->grade . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);
        return $data;
    }




    public function update(Request $req, $id){
    
    }


}