@extends('layout')

@section('header-center')
	<div id="view-by">View by</div>
	<div><a href="#">Top</a> | <a href="#">New</a></div>
@stop


@section('content')
	<!--<div class="time-selector">Links from</div>-->

	<div id="subreddit-links-area">
		@foreach ($posts as $post)
			@include('posts.post-title')
		@endforeach
	</div>

	<div id="new-content-links">
		<ul>
			<li><a href="{{ appRoot() }}posts/new">Submit a new link</a></li>
			<li><a href="{{ appRoot() }}posts/new?selfpost=true">Submit a new text post</a></li>
			<li><a href="{{ appRoot() }}subreddits/new">Create your own subreddit</a></li>
		</ul>
	</div>
@stop