<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');

Route::get('/login', 'LoginController@index')->name('login');

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function ($router) {
    // TODO: 

    // Route::view('/admin/customers', 'admin.customers');
});