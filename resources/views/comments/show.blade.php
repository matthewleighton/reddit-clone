@extends('layout')

@section('content')
	
	

	@if ($post->textpost)
		@section('textpost-body')
			<div class="textpost-body">{{ $post->body }}</div>
		@stop
	@endif

	@include('posts.post-title')

	<div class="comments-section">
		@if (Auth::user())
			<form method="POST" action="/comments/save">
				<input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
				<input type="hidden" name="post_id" value="{{ $post['id'] }}">

				<textarea class="comment-input" name="body" placeholder="Write a comment..." required></textarea><br/>
				<button type="submit">Save</button>
			</form>
			<br/>
		@endif

		@if (count($post->comments) < 1)
			<span>There doesn't appear to be anything there.</span>
		@else
			@foreach ($post->comments as $comment)
				@if (!$comment['parent_id'])
					@include('comments.comment')
				@endif
			@endforeach
		@endif
	</div>

	

@stop