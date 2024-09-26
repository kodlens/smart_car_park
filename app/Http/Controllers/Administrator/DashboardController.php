<?php

namespace App\Http\Controllers\Administrator;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;



class DashboardController extends Controller
{
    //

    public function index(){
        return view('administrator.dashboard');
    }

    public function loadReport(){
        $report = \DB::select("
            SELECT
            a.id,
            a.remarks,
            SUM(a.price) AS total_price,
            a.transaction_date,
            MONTHNAME(a.transaction_date) AS month_name
            FROM
            park_sales a
            GROUP BY MONTH(a.transaction_date)
        ");

        return $report;
    }



}
