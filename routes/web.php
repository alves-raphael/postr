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
    return view('welcome');
})->name('home');


Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback')->name('facebook.callback');


Route::group(['middleware' => ['guest']], function(){
    
    Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
    
    Route::get('login', function(){
        return view('login');
    })->name('login');
});

Route::group(['middleware' => ['auth']], function(){

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

});