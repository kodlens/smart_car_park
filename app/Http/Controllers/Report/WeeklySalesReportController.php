<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParkSale;

class WeeklySalesReportController extends Controller
{
    public function index(){
        return view('reports.weekly-sales-report');
    }

    public function loadWeeklySalesReport(Request $req){
        $startDate = date('Y-m-d', strtotime($req->inputdate));
        $endDate = date('Y-m-d', strtotime($startDate . ' +7 days'));

        $sales = ParkSale::whereBetween('transaction_date', [$startDate, $endDate])
            ->get();

        return $sales;
    }
}
