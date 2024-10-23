<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParkSale;
use Auth;

class PaymentHistoryController extends Controller
{
    public function index(){
        return view('user.payment-history');
    }

    public function getData(Request $req){
        $sort = explode('.', $req->sort_by);

        $user = Auth::user();

        $data = ParkSale::with(['park_reservation.park', 'user', 'park'])
            ->where('remarks', 'like', $req->search . '%')
            ->where('user_id', $user->user_id)
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }
    
}
