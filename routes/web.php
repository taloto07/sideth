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

Route::delete('postimages/{id}', 'PostImageController@destroy')
->name('postimages.destroy');

Route::get('posts/search', 'PostController@search')
->name('posts.search');
Route::resource('posts', 'PostController');

Route::get('test', function(){
	
	return App\Http\Controllers\PostController::SORTS;
});
