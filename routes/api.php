<?php

use Illuminate\Http\Request;

Route::post('/register','AuthController@register');
Route::post('/login','AuthController@login');
Route::get('/user','AuthController@user');
Route::put('/user','AuthController@update')->middleware('auth:api');
Route::post('/logout','AuthController@logout');

Route::get('/user/{id}','UserController@show');

Route::get('/users','UserController@index');

Route::group(['prefix'=>'posts'],function(){
    Route::post('/','PostController@store')->middleware('auth:api');
    Route::get('/all','PostController@index');
    Route::get('/','PostController@top');
    Route::get('/{id}','PostController@show');
    Route::delete('/{id}','PostController@destroy')->middleware('auth:api');
    Route::group(['prefix'=>'/{id}/comment'],function(){
        Route::post('/','CommentController@store')->middleware('auth:api');
    });
    Route::group(['prefix'=>'/{id}/likes'],function(){
        Route::post('/','PostLikeController@store')->middleware('auth:api');
    });
});
