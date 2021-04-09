<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthLoginController extends Controller{

    public function Login(){

    }

    public function doLogin(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (auth()->guard('web')->attempt(['email' => $request->email , 'password' => $request->password])){
            return response('success' , 204);
        }
    }

    public function logout(){
        auth()->guard('web')->logout();
    }

}
