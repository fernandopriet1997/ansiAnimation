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
Route::post('/setFotogram', 'ApiController@saveAnimation')->name('save.image');
Route::post('/renderAnimation', 'ApiController@renderAnimation')->name('renderAnimation');
Route::get('/downloadProyect/{fileName}', 'ApiController@downloadProyect')->name('downloadAnimation');