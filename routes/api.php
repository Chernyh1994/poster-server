<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('V1')->namespace('V1')->group(function() {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::middleware('auth:sanctum')->get('user', 'AuthController@name');
});

Route::middleware('api')->prefix('post')->namespace('V1')->group(function() {
    Route::get('posts', 'PostController@index');
    Route::post('create', 'PostController@store');
});
