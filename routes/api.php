<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('V1')->namespace('V1')->group(function() {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('name', 'AuthController@name');
});


