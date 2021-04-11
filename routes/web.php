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
//
//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>'auth'] , function(){
    Route::get('/','NewsFeedController@index');
    Route::get('/profile/{id}','ProfileController@index');
    Route::post('/post','PostController@store');
    Route::post('/post/like/{id}','PostLikeController@store');
    Route::post('/post/comment/{id}','PostCommentController@store');
    Route::post('/follow/{id}','FollowController@store');
    Route::post('/profile','ProfileController@store');
});

