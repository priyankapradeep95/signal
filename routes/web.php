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

Route::get('/','\Signal\Controllers\HomeController@index')->name('home');
Route::get('/register','\Signal\Controllers\AuthController@getRegister');
Route::post('/register','\Signal\Controllers\AuthController@postRegister');
Route::post('/','\Signal\Controllers\AuthController@login');



Route::group(['middleware' => 'auth'],function(){

    Route::get('/dashboard','\Signal\Controllers\HomeController@getDashboard');
    Route::get('/logout','\Signal\Controllers\AuthController@logout')->name('logout');
    Route::post('/send-request','\Signal\Controllers\HomeController@sendFriendRequest');
    Route::post('/approve-request','\Signal\Controllers\HomeController@acceptRequest');
    Route::post('/reject-request','\Signal\Controllers\HomeController@rejectRequest');

    Route::get('/edit-profile','\Signal\Controllers\AuthController@getEditProfile');
    Route::post('/edit-profile','\Signal\Controllers\AuthController@postEditProfile');
    
});
