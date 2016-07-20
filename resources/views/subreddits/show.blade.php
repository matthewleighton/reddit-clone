@extends('layout')

@section('header-center')
	<div id="view-by">View by</div>
	<div><a href="#">Top</a> | <a href="#">New</a></div>
@stop


@section('content')
	<div class="time-selector">Links from</div>

	<div id="subreddit-links-area">
		This is the list of posts<br/>
		{{ $data['time'] }}<br/><br/>

		@foreach ($data['posts'] as $post)		
			<p><a href="#" class="post-link">{{ $post->title }}</a></p>
		@endforeach
	</div>

	<div id="new-content-links">
		<ul>
			<li><a href="/posts/new">Submit a new link</a></li>
			<li><a href="/posts/new?selfpost=true">Submit a new text post</a></li>
			<li><a href="/subreddits/new">Create your own subreddit</a></li>
		</ul>
	</div>
@stop