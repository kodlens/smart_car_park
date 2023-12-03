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
