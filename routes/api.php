<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getAllForMakers', 'API\HomeController@getAllForMakers');
Route::get('/getAllForTypes', 'API\HomeController@getAllForTypes');

Route::get('/getMakers', 'API\HomeController@getMakers');
Route::post('/addMaker', 'API\HomeController@addMaker');
Route::post('/updateMaker', 'API\HomeController@updateMaker');
Route::post('/deleteMaker', 'API\HomeController@deleteMaker');

Route::get('/getTypes', 'API\HomeController@getTypes');
Route::post('/addType', 'API\HomeController@addType');
Route::post('/updateType', 'API\HomeController@updateType');
Route::post('/deleteType', 'API\HomeController@deleteType');

Route::get('/getBeer', 'API\HomeController@getBeer');
Route::get('/getAvailableMakersAndTypes', 'API\HomeController@getAvailableMakersAndTypes');
Route::post('/addBeer', 'API\HomeController@addBeer');
Route::post('/updateBeer', 'API\HomeController@updateBeer');
Route::post('/deleteBeer', 'API\HomeController@deleteBeer');
