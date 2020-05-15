<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('V1')->namespace('V1')->group(function() {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

    Route::middleware('auth:sanctum')->group(function() {
        Route::apiResource('post', 'PostController');
        Route::get('user/posts', 'PostController@showMyPosts');
        Route::post('post/like', 'PostController@postLike');

        Route::apiResource('post.comment', 'CommentController');
        Route::post('comment/like', 'CommentController@commentLike');
        
        Route::get('user', 'UserController@myProfile');
        Route::put('user', 'UserController@update');
        Route::get('user/{id}', 'UserController@userProfile');
    });
});
