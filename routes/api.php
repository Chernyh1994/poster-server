<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('V1')->namespace('V1')->group(function() {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::middleware('auth:sanctum')->get('user', 'AuthController@name');
});

Route::middleware('api')->prefix('post')->namespace('V1')->group(function() {
    Route::get('posts/{offset}', 'PostController@index');
    Route::post('create', 'PostController@store');
    Route::get('get/{id}', 'PostController@getPost');
});

Route::middleware('api')->prefix('comment')->namespace('V1')->group(function() {
    Route::get('/{id}/{offset}', 'CommentPostController@index');
    Route::post('create', 'CommentPostController@createComment');
});

Route::middleware('api')->prefix('subcomment')->namespace('V1')->group(function() {
    Route::get('/{parenId}', 'SubCommentController@getSubComment');
    Route::post('create', 'SubCommentController@createSubComment');
});
