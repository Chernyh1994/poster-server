<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('airlock')->namespace('Auth')->group(function() {
    Route::post('register', 'AuthController@register');
    Route::post('token', 'AuthController@token');
    Route::post('login', 'LoginController@login');
});

Route::middleware('auth:airlock')->get('/name', function (Request $request) {
    return response()->json(['name' => $request->user()->name]);
});




