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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/login',function () {
    return view('auth/login');
})->name('login');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('confirm', 'Auth\RegisterController@post')->name('user.register_post');
Route::get('register/confirm', 'Auth\RegisterController@confirm')->name('user.register_confirm');
Route::post('register/confirm', 'Auth\RegisterController@register')->name('user.register_register');
Route::get('register/complete', 'Auth\RegisterController@complete')->name('user.register_complete')->middleware(['auth']);
Route::group(['prefix' => 'product'],function(){
    Route::get('index', 'OnlineProductController@index')->name('product');
    Route::post('index', 'OnlineProductController@stock')->name('product.stock');
    Route::get('cart', 'OnlineProductController@cart')->name('product.cart');
    Route::get('show/{id}', 'OnlineProductController@show')->name('product.show');
    Route::post('add/{id}', 'OnlineProductController@add')->name('product.add');
    Route::post('cart', 'OnlineProductController@cartPost')->name('product.cartPost');
    Route::get('confirm', 'OnlineProductController@confirm')->name('product.confirm');
    Route::post('purchase', 'OnlineProductController@purchase')->name('product.purchase');
    Route::get('purchase', 'OnlineProductController@purchase')->name('product.purchase');
    Route::get('complete', 'OnlineProductController@viewComplete')->name('product.complete');
});



Auth::routes();