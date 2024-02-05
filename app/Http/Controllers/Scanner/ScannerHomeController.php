<?php

namespace App\Http\Controllers\Scanner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScannerHomeController extends Controller
{
    //
    public function index(){
        return view('scanner.scanner-index');
    }
}
