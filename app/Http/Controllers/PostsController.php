<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

class PostsController extends Controller
{
    public function create(Request $request)
    {
    	if (!Auth::user()) {
            return redirect()->action('UsersController@login');
        }



    	return view('posts.create');
    }

    public function save()
    {
    	return 'This is the posts save action.';
    }
}