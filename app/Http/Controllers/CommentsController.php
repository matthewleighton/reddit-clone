<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Subreddit;
use App\Post;

class CommentsController extends Controller
{
    public function show($subreddit, $post)
    {
    	$subreddit = Subreddit::where('name', $subreddit)->first();
    	$post = Post::find($post);

    	$data = array(
    		'subreddit' => $subreddit,
    		'post' => $post
    	);

    	return view('comments.show')->with('post', $post);

		//return view('comments.show', compact('data'));
    }
}
