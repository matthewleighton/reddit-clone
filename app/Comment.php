<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['score'];
    
    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function post()
    {
    	return $this->belongsTo(Post::class);
    }

    public function parent()
    {
    	return $this->belongsTo(Comment::class);
    }

    public function children()
    {
    	return $this->hasMany(Comment::class, 'parent_id');
    }

    public function votes()
    {
        return $this->morphMany('App\Vote', 'votable');
    }

    public function displayScore()
    {
    	$string = $this['score'] . ' point';

    	if ($this['score'] != '1') {
    		$string .= 's';
    	}

    	return $string;
    }

    // Adds a class identifying the comment as a child comment.
    public function addChildClass()
    {
    	if ($this['parent_id']) {
    		return 'child-comment';
    	}

    	return '';
    }

    // Adds a class specifying a comment which was linked to directly.
    public function permalinkClass($permalinkId)
    {
    	if ($this['id'] == $permalinkId) {
    		return 'linked-comment';
    	}
    	
    	return '';
    }
}
