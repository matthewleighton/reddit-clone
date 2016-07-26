@extends('layout')

@section('content')
	<div class="comments-page">
		@if ($post->textpost && !isset($comment) && $post['body'] != '')
			@section('textpost-body')
				<div class="textpost-body">{{ $post->body }}</div>
			@stop
		@endif

		@include('posts.post-title')

		<div class="comments-section">
			
			@if (isset($comment))
				<div class="permalink-comment-alert">
					You are viewing a single comment's thread.<br/>
					<a href="{{ $post->commentsHref() }}">View the rest of the comments &rarr;</a>
				</div>
				
			@endif

			@if (Auth::user() && !isset($comment))
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
			@elseif (!isset($comment))
				@foreach ($post->comments as $comment)
					@if (!$comment['parent_id'])
						@include('comments.comment')
					@endif
				@endforeach
			@else
				@include('comments.comment')
			@endif
		</div>
	</div>
@stop