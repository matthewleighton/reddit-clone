<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	public function subreddit()
	{
		return $this->belongsTo(Subreddit::class);
	}

	public function generateHref()
	{
		if ($this['textpost']) {
			// TODO - Add link to the comments page.
			$this['href'] = '#';
		} else {
			//TODO - Account for whether the 'https://' is already included in the url.
			$this['href'] = "https://" . $this['url'];
		}
	}
}
