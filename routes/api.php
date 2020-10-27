<?php

use Illuminate\Http\Request;

Route::post('/register','AuthController@register');
Route::post('/login','AuthController@login');
Route::get('/user','AuthController@user');
Route::post('/logout','AuthController@logout');

Route::group(['prefix'=>'posts'],function(){
    Route::post('/','PostController@store')->middleware('auth:api');
    Route::get('/','PostController@index');
    Route::get('/{id}','PostController@show');
    Route::put('/{id}','PostController@update')->middleware('auth:api');

});
