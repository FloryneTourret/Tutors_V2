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

Route::get('/dashboard',
    'DashboardController@index'
)->name('dashboard');

Route::get('/dashboard/events',
    'DashboardController@events'
)->name('events');
Route::get('/dashboard/event/{id}',
    'DashboardController@event'
)->name('event');

Route::get('/dashboard/suggestions',
    'DashboardController@index'
)->name('suggestions');
Route::get('/dashboard/suggestion/{id}',
    'DashboardController@index'
)->name('suggestion');

Route::get('/dashboard/sessions',
    'DashboardController@index'
)->name('sessions');
Route::get('/dashboard/suivi/{id}',
    'DashboardController@index'
)->name('suivi');

Route::put('/dashboard/user/update/{value}',
    'DashboardController@userupdate'
)->name('user');
Route::get('/dashboard/user/{username?}',
    'DashboardController@user'
)->name('user');


Route::get('/login',
    'LoginController@index'
)->name('login');

Route::get('/logout',
    'LogoutController@index'
)->name('logout');


Route::get('/{category?}',
    'HomeController@index'
)->name('home');




// Route::group(['prefix' => 'admin'], function () {
//     Voyager::routes();
// });
