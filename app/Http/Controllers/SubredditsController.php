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

        if (!$request->get('sort')) {
            $sortBy = 'name';
        } else {
            $sortBy = $sortTypes[$request->get('sort')];
        }
    
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
        
        $times = [
            'hour' => '-1 hour',
            'day' => '-24 hours',
            'week' => '-7 days',
            'month' => '-30 days',
            'year' => '-1 year',
            'all' => '-50 years',
            '' => '-50 years'
        ];

        $time = $times[$request->query('t')];

        $today = new DateTime();

        $sortBy = Post::getSortingOrder($sort);        

        $posts = Post::restrictByTime($request->query('t'))->orderBy($sortBy, 'desc')->get();
        
    	return view('subreddits.show')->with('posts', $posts)
                                      ->with('subreddit', false)
                                      ->with('subscriptions', false);
    }

    public function show(Request $request, $subreddit, $sort='new')
    {
        $sortBy = Post::getSortingOrder($sort);

        $subreddit = Subreddit::where('name', $subreddit)->first();
        
        $posts = Post::restrictByTime($request->query('t'))->where('subreddit_id', $subreddit['id'])
                                                           ->take(10)->orderBy($sortBy, 'desc')
                                                           ->get();

        return view('subreddits.show')->with('posts', $posts)
                                      ->with('subreddit', $subreddit)
                                      ->with('subscriptions', false);
    }

    public function subscriptions(Request $request, $sort='new')
    {
        $sortBy = Post::getSortingOrder($sort);

        $subscriptions = Auth::user()->subreddits;
        $subscriptionIds = [];

        foreach ($subscriptions as $subscription) {
            array_push($subscriptionIds, $subscription->id);
        }

        $posts = Post::restrictByTime($request->query('t'))->whereIn('subreddit_id', $subscriptionIds)
                                                           ->take(10)->orderBy($sortBy, 'desc')
                                                           ->get();

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
