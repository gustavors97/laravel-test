<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function() {
    Route::post('login', 'Api\AuthController@login');
});

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {

    Route::group(['prefix' => 'customer'], function() {
        Route::get('index', 'Api\CustomerController@index');
        Route::get('getCustomers', 'Api\CustomerController@getCustomers');
        Route::get('getCustomerByID/{id}', 'Api\CustomerController@getCustomerByID');
        Route::post('create', 'Api\CustomerController@create');
        Route::put('update', 'Api\CustomerController@update');
        Route::delete('delete', 'Api\CustomerController@delete');
    });

    Route::group(['prefix' => 'number'], function() {
        Route::get('index', 'Api\NumberController@index');
        Route::get('getNumbers', 'Api\NumberController@getNumbers');
        Route::get('getNumberByID/{id}', 'Api\CustomerController@getNumberByID');
        Route::post('create', 'Api\NumberController@create');
        Route::put('update', 'Api\NumberController@update');
        Route::delete('delete', 'Api\NumberController@delete');
    });

    Route::group(['prefix' => 'number_preference'], function() {
        Route::get('index', 'Api\NumberPreferenceController@index');
        Route::get('getNumbersPreferences', 'Api\NumberPreferenceController@getNumbersPreferences');
        Route::get('getNumberPreferenceByID/{id}', 'Api\CustomerController@getNumberPreferenceByID');
        Route::post('create', 'Api\NumberPreferenceController@create');
        Route::put('update', 'Api\NumberPreferenceController@update');
        Route::delete('delete', 'Api\NumberPreferenceController@delete');
    });

    Route::group(['prefix' => 'user'], function() {
        Route::get('index', 'Api\UserController@index');
        Route::get('getUsers', 'Api\UserController@getUsers');
        Route::get('getUserByID/{id}', 'Api\CustomerController@getUserByID');
        Route::post('create', 'Api\UserController@create');
        Route::put('update', 'Api\UserController@update');
        Route::delete('delete', 'Api\UserController@delete');
    });

    Route::group(['prefix' => 'level'], function() {
        Route::get('index', 'Api\LevelController@index');
        Route::get('getLevels', 'Api\LevelController@getLevels');
        Route::get('getLevelByID/{id}', 'Api\CustomerController@getLevelByID');
        Route::post('create', 'Api\LevelController@create');
        Route::put('update', 'Api\LevelController@update');
        Route::delete('delete', 'Api\LevelController@delete');
    });
});