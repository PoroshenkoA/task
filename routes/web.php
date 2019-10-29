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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/makers', 'RouteController@makers')->name('makers');

Route::get('/types', 'RouteController@types')->name('types');

Route::get('/beer', 'RouteController@beer')->name('beer');

Route::get('/listTypes', 'RouteController@listTypes')->name('listTypes');

Route::get('/listMakers', 'RouteController@listMakers')->name('listMakers');

