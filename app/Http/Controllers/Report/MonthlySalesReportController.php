<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParkReservation;

class MonthlySalesReportController extends Controller
{
    public function index(){
        return view('reports.monthly-sales-report');
    }

    public function loadMonthlySalesReport(Request $req){
        $month = date('m', strtotime($req->inputdate));

        $sales = ParkReservation::whereMonth('start_time', $month)
            ->get();

        return $sales;
    }
}
