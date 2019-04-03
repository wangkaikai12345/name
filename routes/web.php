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

Route::get('/domain', 'ToolController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// 应用
Route::resource('application', 'ApplicationController')->only(['store']);

Route::resource('application.domain', 'DomainController')->only(['store']);
