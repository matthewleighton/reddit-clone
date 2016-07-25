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

    	$object = $this->getObject($type, $id);

    	if (!$this->handleExistingVote($object, $direction)) {
    		return;
    	}

    	$vote = new Vote;
    	$vote->vote_direction = $direction;
    	$vote->user_id = Auth::user()['id'];

    	$object->votes()->save($vote);

    	$amount = $direction == '1' ? '1' : '-1';

    	$this->changeScore($object, $amount);
    }

    private function getObject($type, $id)
    {
    	if ($type == 'post') {
    		return Post::where('id', $id)->first();
    	}

    	return Comment::where('id', $id)->first(); 
    }

    private function changeScore($object, $amount)
    {
    	$originalScore = $object->score;

    	$object->update(['score' => $originalScore + $amount]);
    }

    // If the user has already voted on the object, we must remove that vote before adding the new one.
    private function handleExistingVote($object, $newVoteDirection)
    {
    	$existingVote = $object->votes()->where('user_id', Auth::user()['id'])->first();
    	if (!$existingVote) {
    		return true;
    	}

    	$oldVoteDirection = $existingVote['vote_direction'];

    	$this->removeVote($object, $oldVoteDirection);

    	return $oldVoteDirection == $newVoteDirection ? false : true;
    }

    private function removeVote($object, $oldVoteDirection) {
    	$amount = $oldVoteDirection == '1' ? '-1' : '1';

    	$this->changeScore($object, $amount);

    	$object->votes()->where('user_id', Auth::user()['id'])->delete();
    }

    
}
