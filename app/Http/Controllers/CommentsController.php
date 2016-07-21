<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Comment;
use App\Subreddit;
use App\Post;

use Auth;

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

    public function save(Request $request)
    {
        $this->validate($request, [
            'body' => 'required',
            'post_id' => 'required'
        ]);

        $comment = new Comment;

        $comment->body = $request->get('body');
        $comment->score = 1;
        $comment->user_id = Auth::user()['id'];

        if ($request->get('parent_id')) {
            $comment->parent_id = $request->get('parent_id');
        }

        $post = Post::find($request->get('post_id'));
        $post->comments()->save($comment);

        return back();


        return $request->get('post_id');

        return Auth::user()['name'];

        return $request->get('body');

        return 'This is the comments save method';
    }
}
