@extends('layout')

@section('content')
	<div >
		<h1>All Subreddits</h1><br/>
		<table id="subreddits-list">
			<th><a href="{{ appRoot() }}subreddits?sort=name">Name</a></th>
			<th><a href="{{ appRoot() }}subreddits?sort=posts">Posts</a></th>
			<th><a href="{{ appRoot() }}subreddits?sort=subscribers">Subscribers</a></th>
			@foreach ($subreddits as $sub)
				<tr class="subreddit-listing">
					<td class="subreddit-name"><a href="{{ appRoot() }}r/{{ $sub['name'] }}" class="subreddit-name">r/{{ $sub['name'] }}</a></td>
					<td class="post-count">{{ count($sub['posts']) }} {{ str_plural('post', count($sub['posts'])) }}</td>
					<td class="subscriber-count">{{ count($sub['users']) }} {{ str_plural('subscriber', count($sub['users'])) }}</td>
					<td>@if (Auth::user()->isSubscribedTo($sub['id']))
							<a href="javascript:void(0)" class="subscribe-btn subscribed">unsubscribe</a>
						@else
							<a href="javascript:void(0)" class="subscribe-btn unsubscribed">subscribe</a>
						@endif
						<span id="subscription-id" hidden>{{ $sub['id'] }}</span>
					</td>
				</tr>
			@endforeach
		</table>
	</div>
@stop