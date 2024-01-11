<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    //

    public function index(){
        return view('administrator.dashboard');
    }



    public function loadReports(){

        $report = DB::select('select 
             a.strand_id, a.strand, a.strand_desc,
             (
                select count(*) from enrols where a.strand_id = enrols.strand_id
             ) as no_enrolee
            from strands as a
            ');

        return $report;
    }



}
