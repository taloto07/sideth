<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
	protected $fillable = ['path'];

    public function post(){
    	return $this->belongsTo('App\Post');
    }
}
