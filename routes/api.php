<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['namespace' => 'App\Http\Controllers\Backend'], function () {
    Route::post('/v1/get-category', 'CategoryController@get');
    Route::post('/v1/get-photos', 'PhotoController@get');
    Route::post('/v1/get-photos-by-category', 'PhotoController@getPhotosByCateogry');

});

