<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'api/line'], function () {
    Route::get('messages', function () {
        return view('line');
    });
    Route::post('messages', 'Api\Line\MessagesController@index');
});

Route::group(['prefix' => 'back'], function () {
	Route::get('admin', 'Back\AdminController@index');
	Route::post('admin/login', 'Back\AdminController@login');
    Route::get('admin/logout', 'Back\AdminController@logout');

	Route::get('dashboard', 'Back\DashboardController@index');
});