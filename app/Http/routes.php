<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'SubredditsController@all');

Route::get('{sort?}', 'SubredditsController@all')->where('sort', '^(new|top)$' );


Route::get('users/new', 'UsersController@create');

Route::post('users/create', 'UsersController@save');

Route::get('users/login', 'UsersController@loginForm');

Route::post('users/login', 'UsersController@login');

Route::get('users/logout', 'UsersController@logout');



Route::get('posts/new', 'PostsController@create');

Route::post('posts/new', 'PostsController@save');



Route::get('subreddits/new', 'SubredditsController@create');

Route::post('subreddits/new', 'SubredditsController@save');



Route::get('subscriptions', 'SubredditsController@subscriptions');

Route::get('subscriptions/{sort?}', 'SubredditsController@subscriptions')->where('sort', '^(new|top)$' );

Route::get('subscriptions/create/{subreddit}', 'SubscriptionsController@create');

Route::get('subscriptions/destroy/{subreddit}', 'SubscriptionsController@destroy');



Route::get('r/{subreddit}/{sort?}', 'SubredditsController@show')->where('sort', '^(new|top)$' );

Route::get('r/{subreddit}/comments/{post}', 'CommentsController@index');

Route::get('r/{subreddit}/comments/{post}/{comment}', 'CommentsController@show');


Route::post('comments/save', 'CommentsController@save');




Route::get('votes/{direction}/{type}/{id}', 'VotesController@submitVote')->where('direction', '^(0|1)$')
																		 ->where('type', '^(post|comment)$');


Route::get('users/confirm', 'UsersController@confirm');