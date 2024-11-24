<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    //
    public function index(){
        return view('registration');
    }

    public function store(Request $req){
        //return $req;


        $req->validate([
            'username' => ['required', 'string', 'max:30', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'lname' => ['string', 'max: 50', 'required'],
            'fname' => ['string', 'max: 50', 'required'],
            'sex' => ['string', 'max: 10', 'required'],
            'contact_no' => ['required', 'regex:/^9\d{9}$/', 'unique:users'],
            // 'province' => ['string', 'max: 10', 'required'],
            // 'city' => ['string', 'max: 10', 'required'],
            // 'barangay' => ['string', 'max: 10', 'required'],
            // 'zipcode' => ['string', 'max: 10', 'required'],
        ],[
            'contact_no.regex' => 'Invalid mobile number format. Accepted format is 9161231234'
        ]);


        User::create([
            'username' => $req->username,
            'password' => Hash::make($req->password),
            'lname' => strtoupper($req->lname),
            'fname' => strtoupper($req->fname),
            'mname' => strtoupper($req->mname),
            'suffix' => strtoupper($req->suffix),
            'sex' => strtoupper($req->sex),
            'email' => $req->email,
            'contact_no' => $req->contact_no,
            // 'province' => $req->province,
            // 'city' => $req->city,
            // 'barangay' => $req->barangay,
            // 'street' => $req->street,
            // 'zipcode' => $req->zipcode,
            'role' => 'USER'
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }
}
