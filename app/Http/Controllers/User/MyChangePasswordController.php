<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class MyChangePasswordController extends Controller
{
    public function index(){
        return view('user.my-change-password');
    }

    public function changePassword(Request $req){

        $req->validate([
            'old_password' => 'required',
            'password' => 'confirmed|min:4|different:old_password',
        ]);

        if (Hash::check($req->old_password, Auth::user()->password)) { 
        
           $data = Auth::user();
           $data->password = Hash::make($req->password);
           $data->save();

           return response()->json([
            'status' => 'changed'
           ], 200);
        }else{
            return response()->json([
                'errors' => [
                    'old_password' => ['Invalid password.']
                ]
            ], 422);
        }

    }
}
