<?php

namespace App\Http\Controllers\Administrator\Print;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enrol;

class PrintCoeController extends Controller
{
    //

    public function index(Request $req){
        $students = Enrol::with(['academic_year', 'learner', 'semester', 'track', 'strand.courses.course', 'section'])
            ->where('academic_year_id', $req->ay)
            ->orderBy('section_id', 'asc')
            ->get();
        return view('administrator.print.print-page-coe')
            ->with('students', $students);
    }


}
