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

        /////////////////////

        $posts = Post::all();

        //foreach ($posts as $post) {
            //$post->generateHref();
        //}

    	$data = array(
    		'time' => $time,
    		'posts' => $posts,
            'user' => $user
    	);

    	return view('subreddits.show', compact('data'));
    }

    public function create()
    {
        if (!Auth::user()) {
            return redirect()->action('UsersController@login');
        }

        return view('subreddits.create');   
    }

    public function save(Request $request)
    {
        // Remove trailing whitespace before validation.
        $request->merge(['name' => trim($request->get('name'))]);

        $this->validate($request, [
            'name' => 'required|max:255|letters_only'
        ]);

        $subreddit = new Subreddit;
        $subreddit->name = $request->get('name');
        $subreddit->save();

        return redirect()->action('SubredditsController@home');
    }
}
