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
        Route::get('getCustomers', 'Api\CustomerController@getCustomers');
        // Route::post('create', 'Api\CustomerController@create');
        // Route::delete('delete', 'Api\CustomerController@delete');
    });

    Route::group(['prefix' => 'number'], function() {
        Route::get('getNumbers', 'Api\NumberController@getNumbers');
    });
});