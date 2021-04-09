<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthRegisterController extends Controller{

    public function Login(){

    }

    public function register(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
        ]);

        $user = User::create($data);
        auth()->guard('web')->login($user);
        return $user;
    }


}
