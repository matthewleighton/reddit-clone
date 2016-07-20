<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Subreddit;
use App\Post;
use Auth;

class SubredditsController extends Controller
{
    public function home(Request $request)
    {
    	$user = Auth::user()['name'];

        // TODO - Figure out a way of using the query string to define the time period to find posts from.
    	// e.g. 24 hours is default, else past week/month/year/all.
    	
    	$validTimes = ['day', 'week', 'month', 'year', 'all'];

    	$time = 'day';
    	$input = $request->input('time');

    	if (in_array($input, $validTimes)) {
    		$time = $input;
    	}

    	$posts = ['This is a post title', 'This is another post title', 'And a third post title!'];

        $posts = Post::all();

    	$data = array(
    		'time' => $time,
    		'posts' => $posts,
            'user' => $user
    	);

    	//return view('subreddits.show', compact($data));

    	return view('subreddits.show')->with('data', $data);
    }

    public function create()
    {
        return 'This is the subreddit creation method.';
    }
}
