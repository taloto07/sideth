<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Post;

class PostController extends Controller
{
	public function search(Request $request){
		return Post::search($request)->get();
	}

	public function sorts_view(){
		return Post::SORTS_VIEW;
	}

	public function show(Request $request, $id){
		return Post::findOrFail($id);
	}
}
