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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login',function () {
    return view('auth/login');
});

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('user.resister_show');
Route::post('confirm', 'Auth\RegisterController@post')->name('user.resister_post');
Route::get('register/confirm', 'Auth\RegisterController@confirm')->name('user.register_confirm');
Route::post('register/confirm', 'Auth\RegisterController@register')->name('user.resister_resister');
Route::get('register/complete', 'Auth\RegisterController@complete')->name('user.register_complete');

Route::group(['prefix' => 'test', 'middleware' => 'auth'],function(){
    Route::get('/index', function() {
        return view('test/test');
    })->name('test');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');