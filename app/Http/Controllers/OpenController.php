<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AcademicYear;
use App\Models\Semester;
use App\Models\Track;
use App\Models\Strand;
use App\Models\GradeLevel;

class OpenController extends Controller
{
    //

    public function loadAcademicYears(){
        return AcademicYear::orderBy('academic_year_code', 'desc')
            ->get();
    }


    public function loadSemesters(){
        return Semester::orderBy('semester', 'asc')
            ->get();
    }

    public function loadTracks(){
        return Track::orderBy('track', 'asc')
            ->get();
    }

    public function loadStrands(Request $req){
        $trackId = $req->trackid;

        return Strand::where('track_id', $trackId)
            ->orderBy('strand', 'asc')
            ->get();
    }


   public function loadGradeLevels(){
        return GradeLevel::where('active', 1)
            ->orderBy('id', 'asc')
            ->get();
    }


}
