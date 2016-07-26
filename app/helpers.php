<?php

// Return the appropriate root path relative to the server's public directory based on environment.
function appRoot()
{
	if (App::environment() == 'production') {
		// This app's public directory will be stored in /reddit. Change if need be.
		return '/reddit/';
	}

	return '/';
}

// Return the href to either the sort by 'new' or 'top' page, based on whether we're
// looking at a subbreddit page, subscription page, or front page.
function getSortHref($subreddit, $subscriptions, $sort='top')
{
	if ($subreddit) {
		return appRoot() . "r/" . $subreddit['name'] . "/" . $sort;
	} else if ($subscriptions) {
		return appRoot() . "subscriptions/" . $sort;
	}

	return appRoot() . $sort;
}

// Return the appropriate html image tag for an up/downvote arrow with the correct colour.
function generateVoteArrow($post, $comment, $direction)
{
	$upStatus = 'inactive';
	$downStatus = 'inactive';

	$object = $comment ? $comment : $post;

	if ($votes = $object->votes()->where('user_id', Auth::user()['id'])->first()) {
		if ($votes['vote_direction']) {
			$upStatus = 'active';
		} else {
			$downStatus = 'active';
		}
	}

	$directionStatus = $direction == 'up' ? $upStatus : $downStatus;

	$tag = "<img class='vote-arrow " . $direction . "vote " . $directionStatus . 
		   "' src='" . appRoot() . "img/" . $directionStatus . "-" . $direction . "vote.png'/>";

	return $tag;
}

function getVoteCounterStatus($post, $comment)
{
	$object = $comment ? $comment : $post;

	if ($votes = $object->votes()->where('user_id', Auth::user()['id'])->first()) {
		return $votes['vote_direction'] == '1' ? 'upvoted' : 'downvoted';
	}

	return '';
}


?>