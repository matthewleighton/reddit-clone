<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DateTime;

use App\Subreddit;
use App\Post;


class SubredditsController extends Controller
{
    public function index(Request $request)
    {
        $sortTypes = [
            'name' => 'name',
            'posts' => 'posts',
            'subscribers' => 'users'
        ];

        $sortBy = !$request->get('sort') ? 'name' : $sortTypes[$request->get('sort')];
    
        $subreddits = Subreddit::get();

        if ($sortBy == 'name') {
            $subreddits = $subreddits->sortBy('name');
        } else {
            $subreddits = $subreddits->sortBy(function($subreddit) use (&$sortBy)
            {
                return $subreddit[$sortBy]->count();
            });
            
            $subreddits = $subreddits->reverse();
        }

        return view('subreddits.index')->with('subreddits', $subreddits);
    }

    public function all(Request $request, $sort = 'new')
    {     
        $sortBy = Post::getSortingOrder($sort);
        $today = new DateTime();
        $time = Post::getConstraintTime($request->get('t'));

        $posts = Post::where('created_at', '>', $today->modify($time))
            ->orderBy($sortBy, 'desc')
            ->paginate(15);
        
    	return view('subreddits.show')->with('posts', $posts)
                                      ->with('subreddit', false)
                                      ->with('subscriptions', false);
    }

    public function show(Request $request, $subreddit, $sort='new')
    {
        $subreddit = Subreddit::where('name', $subreddit)->first();
        
        $sortBy = Post::getSortingOrder($sort);
        $time = Post::getConstraintTime($request->get('t'));
        $today = new DateTime();

        $posts = Post::where('created_at', '>', $today->modify($time))
            ->where('subreddit_id', $subreddit['id'])
            ->orderBy($sortBy, 'desc')
            ->paginate(15);
        
        return view('subreddits.show')->with('posts', $posts)
                                      ->with('subreddit', $subreddit)
                                      ->with('subscriptions', false);
    }

    public function subscriptions(Request $request, $sort='new')
    {
        $subscriptions = Auth::user()->subreddits;
        $subscriptionIds = [];
        
        foreach ($subscriptions as $subscription) {
            array_push($subscriptionIds, $subscription->id);
        }

        $sortBy = Post::getSortingOrder($sort);
        $time = Post::getConstraintTime($request->get('t'));
        $today = new DateTime();

        $posts = Post::whereIn('subreddit_id', $subscriptionIds)
            ->where('created_at', '>', $today->modify($time))
            ->orderBy($sortBy, 'desc')
            ->paginate(15);

        return view('subreddits.show')->with('posts', $posts)
                                      ->with('subscriptions', true)
                                      ->with('subreddit', false);
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
        $request->merge(['name' => strtolower(trim($request->get('name')))]);

        $this->validate($request, [
            'name' => 'required|max:255|letters_only'
        ]);

        $subreddit = new Subreddit;
        $subreddit->name = $request->get('name');
        $subreddit->save();

        Auth::user()->subscribeTo($subreddit['id']);

        return redirect('r/' . $subreddit['name']);
    }
}