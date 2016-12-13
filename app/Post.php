<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Post extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

    const SORTS_VIEW = [
        1 => 'Newest First',
        2 => 'Oldest First',
    ];

    const SORTS_BY = [
        1 => ['field' => 'created_at', 'order' => 'desc'],
        2 => ['field' => 'created_at', 'order' => 'asc']
    ];

    public static function boot(){
        parent::boot();

        static::deleted(function($post){
            $post->images()->delete();
        });

        static::restored(function($post){
            $post->images()->restore();
        });
    }

    public function category(){
    	return $this->belongsTo('App\Category');
    }

    public function location(){
    	return $this->belongsTo('App\Location');
    }

    public function images(){
    	return $this->hasMany('App\PostImage');
    }

    public static function search(Request $request){
        $keyword     = $request->keyword;
        $location_id = $request->location_id;
        $category_id = $request->category_id;

        $titleFilter = collect([['title', 'like', '%' . $keyword . '%']]);
        $descriptionFilter = collect([['description', 'like', '%' . $keyword . '%']]);
        // $posts = Post::where('title', 'like', "%$keyword%");
                    // ->orWhere('description', 'like', "%$keyword%");

        // if location_id exist than add accordingly
        if ($request->has('location_id')) {
            $titleFilter->push(['location_id', '=', $location_id]);
            $descriptionFilter->push(['location_id', '=', $location_id]);
            // $posts = $posts->where('location_id', $location_id);
        }

        // if category_id exist than add accordingly
        if ($request->has('category_id')) {
            $titleFilter->push(['category_id', '=', $category_id]);
            $descriptionFilter->push(['category_id', '=', $category_id]);
            // $posts = $posts->where('category_id', $category_id);
        }

        $posts = Post::Where($titleFilter->toArray())
                        ->orWhere($descriptionFilter->toArray());

        // if sort exist
        if ($request->has('sort') && array_key_exists($request->sort, Post::SORTS_BY)){
            $sortBy = Post::SORTS_BY[$request->sort];
            $posts = $posts->orderBy($sortBy['field'], $sortBy['order']);
        } else {
            $posts = $posts->orderBy('title', 'asc')->orderBy('description', 'asc');
        }

        return $posts;
    }
}
