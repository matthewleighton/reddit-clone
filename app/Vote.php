<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Vote extends Model
{
    public static function submitVote($direction, $type, $id)
    {
    	$object = Vote::getObject($type, $id);

    	if (!Vote::handleExistingVote($object, $direction)) {
    		return;
    	}

    	$vote = new Vote;
    	$vote->vote_direction = $direction;
    	$vote->user_id = Auth::user()['id'];

    	$object->votes()->save($vote);

    	$amount = $direction == '1' ? '1' : '-1';

    	Vote::changeScore($object, $amount);
    }

    private static function getObject($type, $id)
    {
    	if ($type == 'post') {
    		return Post::where('id', $id)->first();
    	}

    	return Comment::where('id', $id)->first(); 
    }

    private static function changeScore($object, $amount)
    {
    	$originalScore = $object->score;

    	$object->update(['score' => $originalScore + $amount]);
    }

    // If the user has already voted on the object, we must remove that vote before adding the new one.
    private static function handleExistingVote($object, $newVoteDirection)
    {
    	$existingVote = $object->votes()->where('user_id', Auth::user()['id'])->first();
    	if (!$existingVote) {
    		return true;
    	}

    	$oldVoteDirection = $existingVote['vote_direction'];

    	Vote::removeVote($object, $oldVoteDirection);

    	return $oldVoteDirection == $newVoteDirection ? false : true;
    }

    private static function removeVote($object, $oldVoteDirection) {
    	$amount = $oldVoteDirection == '1' ? '-1' : '1';

    	Vote::changeScore($object, $amount);

    	$object->votes()->where('user_id', Auth::user()['id'])->delete();
    }
}
