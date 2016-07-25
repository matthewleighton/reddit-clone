<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subreddit extends Model
{
	public function posts()
	{
		return $this->hasMany(Post::class);
	}

	public function users()
	{
		return $this->belongsToMany(User::class);
	}

	public function getTopSortHref($subreddit, $subscription)
	{
		return 'test';
	}
}
