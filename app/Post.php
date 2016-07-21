<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	public function subreddit()
	{
		return $this->belongsTo(Subreddit::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}

	public function commentsLinkText()
	{
		$numberOfComments = count($this->comments);

		if ($numberOfComments > 1) {
			return $numberOfComments . " comments";
		} else if ($numberOfComments == 0) {
			return "Comment";
		} else {
			return "1 comment";
		}
	}

	public function postHref()
	{
		if ($this['textpost']) {
			return $this->commentsHref();
		} else {
			//TODO - Account for whether the 'https://' is already included in the url.
			return "https://" . $this['url'];
		}
	}

	public function commentsHref()
	{
		return '/r/' . $this->subreddit['name'] . '/comments/' . $this['id'];
	}

	public function timeSincePosted()
	{
		return $this->created_at->diffForHumans();
	}
}
