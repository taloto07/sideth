<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostImage extends Model
{
	use SoftDeletes;
	
	protected $fillable = ['path'];

    public function post(){
    	return $this->belongsTo('App\Post');
    }
}
