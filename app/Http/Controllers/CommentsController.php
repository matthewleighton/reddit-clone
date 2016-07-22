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

    	return view('comments.show')->with('post', $post);
    }

    public function save(Request $request)
    {
        if (!Auth::user()) {
            return redirect()->action('SubredditsController@home');
        }

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
    }
}
