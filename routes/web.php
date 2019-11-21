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

Route::get('/{category?}',
    'HomeController@index'
)->name('home');

Route::get('/dashboard',
    'DashboardController@index'
)->name('dashboard');

Route::get('/login',
    'LoginController@index'
)->name('login');

Route::get('/logout',
    'LogoutController@index'
)->name('logout');

// Route::group(['prefix' => 'admin'], function () {
//     Voyager::routes();
// });
