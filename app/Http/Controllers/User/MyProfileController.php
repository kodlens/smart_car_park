<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyProfileController extends Controller
{
    //


    public function index()
    {
        return view('user.my-profile');
    }

    public function loadProfile(){
        return Auth::user();
    }

    public function update(Request $req, $id){

        $req->validate([
            'lname' => ['string', 'max: 50', 'required'],
            'fname' => ['string', 'max: 50', 'required'],
            'sex' => ['string', 'max: 10', 'required'],
            'contact_no' => ['required', 'regex:/^(9|\+639)\d{9}$/', 'unique:users'],
        ],[
            'contact_no.regex' => 'Invalid mobile number format. Accepted format is 9161231234'
        ]);

        $data = User::find($id);
        $data->lname = strtoupper($req->lname);
        $data->fname = strtoupper($req->fname);
        $data->mname = strtoupper($req->mname);
        $data->suffix = strtoupper($req->suffix);
        $data->sex = strtoupper($req->sex);
        $data->email = $req->email;
        $data->contact_no = $req->contact_no;

        $data->save();

        return response()->json([
            'status' => 'updated'
        ], 200);




    }





}
