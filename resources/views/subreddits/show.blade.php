@extends('layout')

@section('content')
	<!--<div class="time-selector">Links from</div>-->

	<div class="view-subreddit-by">
		<div id="view-by">View by</div>
			<div class="sort-top-link">
				<a href="{{ getSortHref($subreddit, $subscriptions, 'top') }}" >Top&#x25BE;</a>
				<div class="sort-top-dropdown">
					<a href="{{ getSortHref($subreddit, $subscriptions, 'top') }}/?t=hour" class="time-selection-choice">Past hour</a>
					<a href="{{ getSortHref($subreddit, $subscriptions, 'top') }}/?t=day" class="time-selection-choice">Past 24 hours</a>
					<a href="{{ getSortHref($subreddit, $subscriptions, 'top') }}/?t=week" class="time-selection-choice">Past week</a>
					<a href="{{ getSortHref($subreddit, $subscriptions, 'top') }}/?t=month" class="time-selection-choice">Past month</a>
					<a href="{{ getSortHref($subreddit, $subscriptions, 'top') }}/?t=year" class="time-selection-choice">Past year</a>
					<a href="{{ getSortHref($subreddit, $subscriptions, 'top') }}/?t=all" class="time-selection-choice">All time</a>
				</div>
			</div>	| 
			<a href="{{ getSortHref($subreddit, $subscriptions, 'new') }}" class="sort-new-link">New</a>
	</div>

	<div id="subreddit-links-area">
		@foreach ($posts as $post)
			@include('posts.post-title')
		@endforeach

		@if($subscriptions && !count(Auth::user()['subreddits']))
			<span class="empty-warning">You aren't subscribed to any <a href='{{ appRoot() }}subreddits'>subreddits</a>.</span>
		@elseif (!count($posts))
			<span class="empty-warning">There aren't any posts here.</span>
		@endif

		{!! createPaginationLink($posts, 0) !!}
		{!! createPaginationLink($posts, 1) !!}
	</div>



	<div id="new-content-links">
		<ul>
			<li><a href="{{ appRoot() }}posts/new">Submit a new link</a></li>
			<li><a href="{{ appRoot() }}posts/new?selfpost=true">Submit a new text post</a></li>
			<li><a href="{{ appRoot() }}subreddits/new">Create your own subreddit</a></li>
			<li><a href="{{ appRoot() }}subreddits">View all subreddits</a></li>
		</ul>
	</div>

	@if ($subreddit)
		<div class="sidebar">
			<p class="sidebar-title"><a href="{{ appRoot() }}r/{{ $subreddit['name'] }}">{{$subreddit['name']}}</a></p>
			<p class="subscription-area">
				@if (Auth::user())
					@if (Auth::user()->isSubscribedTo($subreddit['id']))
						<a href="javascript:void(0)" class="subscribe-btn subscribed">unsubscribe</a>
					@else
						<a href="javascript:void(0)" class="subscribe-btn unsubscribed">subscribe</a>
					@endif
					<span id="subscription-id" hidden>{{ $subreddit['id'] }}</span>
				@else
					<a href='{{ appRoot() }}users/new'>Sign up to subscribe!</a>
				@endif
				 <span class="subscriber-count">{{ count($subreddit->users) }} {{ str_plural('reader', count($subreddit->users)) }}</span>
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