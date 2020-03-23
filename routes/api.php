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

Route::prefix('sanctum')->namespace('V1')->group(function() {
    Route::post('register', 'AuthController@register');
    Route::post('token', 'AuthController@token');
    Route::post('logout', 'AuthController@logout');
});

Route::middleware('auth:sanctum')->namespace('V1')->group(function () {
    Route::get('name', 'AuthController@name');
});

