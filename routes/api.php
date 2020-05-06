<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('V1')->namespace('V1')->group(function() {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::apiResource('post', 'PostController');

    Route::middleware('auth:sanctum')->group(function() {
        Route::apiResource('post.comment', 'CommentController');
        Route::get('user/posts', 'PostController@showMyPosts');
        Route::get('user', 'UserController@myProfile');
        Route::put('user', 'UserController@update');
        Route::get('user/{id}', 'UserController@userProfile');
    });
});
