<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
	[
		'prefix' => 'v1',
		'namespace' => 'API\V1'
	],
	function(){
		Route::get('/user', function (Request $request) {
		    return $request->user();
		})->middleware('auth:api');

		Route::group(
			[
				'prefix' => 'posts'
			], 
			function(){
				Route::get('search', 'PostController@search');
				Route::get('sorts_view', 'PostController@sorts_view');
				Route::get('{post}', 'PostController@show');
			}
		);

		Route::group(
			[
				'prefix' => 'locations'
			],
			function(){
				Route::get('/', function(){
					return App\Location::all();
				});
			}
		);

		Route::group(
			[
				'prefix' => 'categories',
			],
			function(){
				Route::get('/', function(){
					return App\Category::all();
				});
			}
		);
	}
);
