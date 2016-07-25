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

?>