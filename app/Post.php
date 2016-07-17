<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	public function subreddit()
	{
		return $this->belongsTo(Subreddit::class);
	}
}
