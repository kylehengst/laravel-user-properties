<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('map');
});

Route::group(['prefix'=>'api'], function(){

    // Users
    Route::post('users', 'UsersController@store');
    Route::post('users/signin', 'UsersController@signin');

    // Properties
    Route::get('properties', 'PropertiesController@index');
    Route::put('properties/{id}', 'PropertiesController@update');

});


