<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

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
}
