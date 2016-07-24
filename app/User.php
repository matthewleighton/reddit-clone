<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function subreddits()
    {
        return $this->belongsToMany(Subreddit::class);
    }

    public function redirectIfLoggedIn()
    {
        if (Auth::user()) {
            return redirect()->action('SubredditsController@home');
        }
    }

    // Returns true if the active user is subscribed to the given subreddit.
    public function isSubscribedTo($subredditId) {
        if ($this->subreddits->contains($subredditId)) {
            return true;
        } else {
            return false;
        }
    }

    public function subscribeTo($subredditId) {
        $this->subreddits()->attach($subredditId);
    }    

    public function unsubscribeFrom($subredditId) {
        $this->subreddits()->detach($subredditId);
        //$subreddit->users()->detach(Auth::user()['id']);
    }

}
