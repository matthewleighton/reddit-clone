<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function post()
    {
    	$this->belongsTo(Post::class);
    }

    public function parent()
    {
    	$this->belongsTo(Comment::class);
    }
}
