<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use App\Subreddit;
use Auth;


class SubscriptionsController extends Controller
{
    public function create($subredditId)
    {
       	if (!Auth::user()->isSubscribedTo($subredditId)) {
    		Auth::user()->subscribeTo($subredditId);
    	}
    }

    public function destroy($subredditId)
    {
    	if (Auth::user()->isSubscribedTo($subredditId)){
    		Auth::user()->unsubscribeFrom($subredditId);
    	}
    }
}
