<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// TODO: Adjust middleware auth here:
Route::group(['prefix' => 'admin'], function() {

    Route::group(['prefix' => 'customer'], function() {
        Route::get('getCustomers', 'Api\CustomerController@getCustomers');
        // Route::post('create', 'Api\CustomerController@create');
        // Route::delete('delete', 'Api\CustomerController@delete');
    });

    Route::group(['prefix' => 'number'], function() {
        Route::get('getNumbers', 'Api\NumberController@getNumbers');
    });
});