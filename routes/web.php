<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/doLogin' , 'Auth\AuthLoginController@doLogin');
Route::post('/logout' , 'Auth\AuthLoginController@logout');
Route::post('/register' , 'Auth\AuthRegisterController@register');

Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '^(?!api\/)[\/\w\.\,-]*');

