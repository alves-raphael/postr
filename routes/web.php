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

Route::get('login/facebook/callback', 'Auth\LoginController@handleFacebookCallback')->name('facebook.callback');


Route::group(['middleware' => ['guest']], function(){

    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::get('login/facebook', 'Auth\LoginController@redirectToProvider')->name('facebook.login');

    Route::get('login', function(){
        return view('login');
    })->name('login');

});

Route::get('test', 'Auth\LoginController@test');

Route::group(['middleware' => ['auth']], function(){

    Route::get('posts/list', "PostController@list")->name('post.list');

    Route::get('posts/create', "PostController@creation")->name('post.create.view');

    Route::post('posts/create', "PostController@create")->name('post.create.new');

    Route::get('post/edit/{id}', 'PostController@editView')->name('post.edit.view');

    Route::post('post/edit/{id}', 'PostController@edit')->name('post.edit');

    Route::get('topics/list', "TopicController@list")->name('topic.list');

    Route::post('topics/create', "TopicController@create")->name('topic.create');

    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('schedule', 'ScheduleController@manage')->name('schedule');

    Route::get('page/create', 'PageController@createMany')->name('page.create');

});
