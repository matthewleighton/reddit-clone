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

	@if (isset($subreddit))
		<div class="sidebar">
			<p class="sidebar-title"><a href="{{ appRoot() }}r/{{ $subreddit['name'] }}">{{$subreddit['name']}}</a></p>
			<p class="subscription-area">
				@if (Auth::user()->isSubscribedTo($subreddit['id']))
					<a href="javascript:void(0)" class="subscribe-btn subscribed">unsubscribe</a>
				@else
					<a href="javascript:void(0)" class="subscribe-btn unsubscribed">subscribe</a>
				@endif
				 <span class="subscriber-count">{{ count($subreddit->users) }} {{ str_plural('reader', count($subreddit->users)) }}</span>
				<span id="subscription-id" hidden>{{ $subreddit['id'] }}</span>
			</p>

			<div class="list-subscribers">
				<br/>
				<ul>
					@foreach($subreddit->users as $user)
						<li>{{ $user['name'] }}</li>
					@endforeach
				</ul>
			</div>
		</div>
	@endif

@stop