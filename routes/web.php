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
    return view('homepage');
});

Route::get('about', function () {
    return view('about');
});

Route::get('contact', function () {
    return view('contact');
});

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');
Route::get('activate/{token}', 'Auth\RegisterController@activate');

Route::get('posts/search', 'PostController@search');
Route::resource('posts', 'PostController');

Route::get('test', function(){
	
	// return asset('storage/images/test/0641d42bac47fac1def7e9de9c9e6338.jpeg');
});
