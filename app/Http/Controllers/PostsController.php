<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Post;
use App\Subreddit;

use Auth;

class PostsController extends Controller
{
    public function create(Request $request)
    {
    	if (!Auth::user()) {
            return redirect()->action('UsersController@login');
        }

        // Used to set the default value of the textpost hidden field.
        if (null !== old('textpost')) {
        	$textpost = old('textpost');
        } else {
        	$textpost = '0';
        }

    	return view('posts.create', compact('textpost'));
    }

    public function save(Request $request)
    {
    	$this->validate($request, [
    		'title' => 'required',
    		'subreddit' => 'required|exists:subreddits,name',
    		'textpost' => 'required',
    		'body' => 'required_if:textpost,1',
    		'url' => 'required_if:textpost,0',
    	]);

    	$textpost = $request->get('textpost');

    	$post = new Post;

    	$post->title = $request->get('title');
    	$post->textpost = $textpost;

    	if ($textpost) {
    		$post->body = $request->get('body');
    	} else {
    		$post->url = $request->get('url');
    	}

    	$subreddit = Subreddit::where('name', $request->get('subreddit'))->first();

    	$subreddit->posts()->save($post);

    	return redirect()->action('SubredditsController@home');
    }
}