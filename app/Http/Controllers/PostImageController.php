<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PostImage;

class PostImageController extends Controller
{

    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('admin');
    }

    public function destroy(Request $request, $id){
    	
    	PostImage::destroy($id);
    	return response()->json(['success' => 'seleted successfully ' . $id]);
    	
    }
}
