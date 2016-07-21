<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function post()
    {
    	return $this->belongsTo(Post::class);
    }

    public function parent()
    {
    	return $this->belongsTo(Comment::class);
    }

    public function displayScore()
    {
    	$string = $this['score'] . ' point';

    	if ($this['score'] != '1') {
    		$string .= 's';
    	}

    	return $string;
    }
}
