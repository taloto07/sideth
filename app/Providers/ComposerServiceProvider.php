<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use App\Location;
use App\Category;

class ComposerServiceProvider extends ServiceProvider{

	/**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
    	View::composer(
    		'*', 'App\Http\ViewComposers\EveryViewComposer'
    	);

    	// View::composer('*', function($view){
    	// 	$locations  = Location::all()->pluck('city', 'id');
    	// 	$categories = Category::all()->pluck('name', 'id');
    	// 	$view->with(compact('locations', 'categories'));
    	// });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}