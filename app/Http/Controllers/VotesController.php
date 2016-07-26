<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use App\Vote;
use App\Post;
use App\Comment;

class VotesController extends Controller
{
    public function votable()
    {
    	return $this->morphTo();
    }

    public function submitVote($direction, $type, $id)
    {
    	if (!auth::user()) {
    		return;
    	}

        Vote::submitVote($direction, $type, $id);
    }

    

    
}
