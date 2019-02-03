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

Route::get('/','PostCodeController@returnPostCodes');
Route::get('/menu', 'PostCodeController@returnAllPostCodes');
Route::get('/data', 'PostCodeController@returnDataForTable');

Route::get('/getCsv', 'PostCodeController@export')->name('export');