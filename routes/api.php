<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('V1')->namespace('V1')->group(function() {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('user', 'AuthController@name')->middleware('auth:sanctum');
    Route::put('user', 'AuthController@update')->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function() {
        Route::apiResource('post', 'PostController');
        Route::apiResource('post.comment', 'CommentController');
        Route::get('user/posts', 'PostController@showPostsUser');
    });
});
