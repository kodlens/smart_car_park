<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WeeklySalesReportController extends Controller
{
    public function index(){
        return view('reports.weekly-sales-report');
    }

    public function loadWeeklySalesReport(Request $req){
        $startDate = date('Y-m-d', strtotime($req->inputdate));
        $endDate = '';
        $sales = ParkSale::whereBetween('transaction_date', [$startDate, $endDate])
            ->where('')
            ->get();

        return $sales;
    }
}
