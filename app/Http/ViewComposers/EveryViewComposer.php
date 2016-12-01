<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

use App\Location;
use App\Category;

class EveryViewComposer{

	/**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
	public function compose(View $view){
		$locations  = Location::all()->pluck('city', 'id');
    	$categories = Category::all()->pluck('name', 'id');
    	$view->with(compact('locations', 'categories'));
	}
}