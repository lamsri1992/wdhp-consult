<?php

use Illuminate\Support\Facades\Route;

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
    return view('index');
});

Route::group(['prefix' => '/'], function () {
	Route::get('consult','jhcis@consult')->name('consult');
	Route::get('consult/send','jhcis@send')->name('consult.send');
	Route::get('datacorrect','jhcis@datacorrect')->name('datacorrect');
	Route::get('search','jhcis@search')->name('search');
	Route::get('delete','jhcis@delete')->name('delete');
});