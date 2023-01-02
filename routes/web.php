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

// route to show the login form
Route::get('/', function () {
    return redirect('/login');
});

Route::get('login', array('as' => 'login', 'uses' => 'App\Http\Controllers\Auth\LoginController@showLogin'));
Route::get('auth/logout', array('as' => 'login', 'uses' => 'App\Http\Controllers\Auth\LoginController@logout'));

// route to process the form
Route::post('login', array('as' => 'login', 'uses' => 'App\Http\Controllers\Auth\LoginController@doLogin'));

Route::group(['middleware' => 'auth', 'namespace' => 'App\Http\Controllers\Backend'], function () {
      Route::resource('/dashboard', 'DashboardController');

      Route::resource('/category', 'CategoryController');

      Route::resource('/admin', 'AdminController');

      Route::resource('/photo', 'PhotoController');


});
