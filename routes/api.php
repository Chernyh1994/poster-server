<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('V1')->namespace('V1')->group(function() {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

    Route::middleware('auth:sanctum')->group(function() {
        Route::apiResource('post', 'PostController');
        Route::get('currentuser/posts/{createdAt}', 'PostController@showMyPosts');
        Route::get('favorite/posts/{createdAt}', 'PostController@showFavoritePosts');
        Route::get('post/{post}/like', 'PostController@postLike');
        Route::get('post/{post}/unlike', 'PostController@postUnlike');

        Route::apiResource('post.comment', 'CommentController');
        Route::get('comment/{comment}/like', 'CommentController@commentLike');
        Route::get('comment/{comment}/unlike', 'CommentController@commentUnlike');
        
        Route::get('user', 'UserController@myProfile');
        Route::put('user', 'UserController@update');
        Route::get('user/{id}', 'UserController@userProfile');
    });
});
