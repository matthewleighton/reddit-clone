<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

use App\Subreddit;
use App\Post;


class SubredditsController extends Controller
{
    public function all(Request $request, $sort = 'new')
    {     
        $sortBy = Post::getSortingOrder($sort);

        $posts = Post::orderBy($sortBy, 'desc')->get();

    	return view('subreddits.show')->with('posts', $posts);
    }

    public function show(Request $request, $subreddit, $sort='new')
    {
        $sortBy = Post::getSortingOrder($sort);

        $subreddit = Subreddit::where('name', $subreddit)->first();
        $posts = Post::where('subreddit_id', $subreddit['id'])->take(10)->orderBy($sortBy, 'desc')->get();

        return view('subreddits.show')->with('posts', $posts)
                                      ->with('subreddit', $subreddit);
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

        Auth::user()->subscribeTo($subreddit['id']);

        return redirect('r/' . $subreddit['name']);
    }

    public function subscriptions(Request $request, $sort='new')
    {
        $sortBy = Post::getSortingOrder($sort);

        $subscriptions = Auth::user()->subreddits;
        $subscriptionIds = [];

        foreach ($subscriptions as $subscription) {
            array_push($subscriptionIds, $subscription->id);
        }

        $posts = Post::whereIn('subreddit_id', $subscriptionIds)->take(10)->orderBy($sortBy, 'desc')->get();

        return view('subreddits.show')->with('posts', $posts)->with('subscriptions', true);
    }
}
