@extends('layout')

@section('content')
	
	

	@if ($post->textpost)
		@section('textpost-body')
			<div class="textpost-body">{{ $post->body }}</div>
		@stop
	@endif

	@include('posts.post-title')

	<div class="comments-section">
		<form method="POST" action="/comments/save">
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
			<input type="hidden" name="post_id" value="{{ $post['id'] }}">

			<textarea class="comment-input" name="body" placeholder="Write a comment..."></textarea><br/>
			<button type="submit">Save</button>
		</form>
		<br/>

		@if (count($post->comments) < 1)
			<span>There doesn't appear to be anything there.</span>
		@else
			@foreach ($post->comments as $comment)
				@if (!$comment['parent_id'])
					<form class="comment-container form-closed" method="POST" action="/comments/save" >
						<input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
						<input type="hidden" name="post_id" value="{{ $post['id'] }}">
						<input type="hidden" name="parent_id" value="{{ $comment['id'] }}">

						@include('votes-section')
						<div class="comment-main">
							<div class="comment-info">
								<span class="minimize-comment">[-]</span> 
								<a href='#'>{{ $comment->user['name'] }}</a> {{ $comment->displayScore() }} {{ $comment->created_at->diffForHumans() }}
							</div>
							<div class="comment-body">
								{{ $comment['body'] }}	
							</div>
							<div class="comment-actions">
								<a href="javascript:void(0)" class="comment-reply-btn">reply</a>
							</div>
						</div>
					</form>
				@endif
			@endforeach
		@endif
	</div>

	

@stop