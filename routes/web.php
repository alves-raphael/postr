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

Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback')->name('facebook.callback');


Route::group(['middleware' => ['guest']], function(){
    
    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::get('login/facebook', 'Auth\LoginController@redirectToProvider')->name('login');

});



Route::group(['middleware' => ['auth']], function(){
    
    Route::get('posts/list', function(){
        return view('post.list');
    })->name('post.list');
    
    Route::get('posts/create', "PostController@creation")->name('post.create');
    
    Route::post('posts/create', "PostController@create")->name('post.create.new');

    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

});