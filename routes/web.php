<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');

Route::get('/login', 'LoginController@index')->name('login');
Route::get('/logout', 'LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function ($router) {
    Route::get('/customers', 'AdminController@customers')->name('admin');
    Route::get('/numbers', 'AdminController@numbers');
    Route::get('/numbers_preferences', 'AdminController@numbersPreferences');
    Route::get('/users', 'AdminController@users');
    Route::get('/levels', 'AdminController@levels');
    Route::get('/logs', 'AdminController@logs');
});