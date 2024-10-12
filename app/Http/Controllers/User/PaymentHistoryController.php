<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParkSale;

class PaymentHistoryController extends Controller
{
    public function index(){
        return view('user.payment-history');
    }

    public function getData(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = ParkSale::with(['park_reservation.park', 'user', 'park'])
            ->where('remarks', 'like', $req->search . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }



}
