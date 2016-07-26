<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Post;
use App\Subreddit;
use App\Vote;

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
    	if (!Auth::user()) {
            return redirect()->action('SubredditsController@home');
        }

        if ($url = $request->get('url')) {
            if (substr($url, 0, 7) != 'http://' && substr($url, 0, 8) != 'https://') {
                $request->merge(['url' => 'http://' . ($request->get('url'))]);
            }
        }

        $this->validate($request, [
    		'title' => 'required',
    		'subreddit' => 'required|exists:subreddits,name',
    		'textpost' => 'required',
    		'url' => 'required_if:textpost,0|true_url',
    	]);

    	$textpost = $request->get('textpost');

    	$post = new Post;

    	$post->title = $request->get('title');
    	$post->textpost = $textpost;
        $post->user_id = Auth::user()['id'];
        $post->score = 0;

    	if ($textpost) {
    		$post->body = $request->get('body');
    	} else {
    		$post->url = $request->get('url');
    	}

        $subredditName = $request->get('subreddit');

        $subreddit = Subreddit::where('name', $subredditName)->first();

    	$newPost = $subreddit->posts()->save($post);

        Vote::submitVote(1, 'post', $newPost['id']);

        return redirect('r/' . $subredditName . '/comments/' . $newPost['id']);
    }
}