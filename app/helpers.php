<?php

// Returns the appropriate root path relative to the server's public directory based on environment.
function appRoot()
{
	if (App::environment() == 'production') {
		// This app's public directory will be stored in /reddit. Change if need be.
		return '/reddit/';
	}

	return '/';
}

?>