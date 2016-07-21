@extends('layout')

@section('content')
	
	

	@if ($post->textpost)
		@section('textpost-body')
			<div class="textpost-body">{{ $post->body }}</div>
		@stop
	@endif

	@include('posts.post-title')

	<div class="comments-section">
		<form method="POST">
			<textarea placeholder="Post a comment"></textarea>
			<button type="submit">Save</button>
		</form>
		<br/>

		@if (count($post->comments) < 1)
			<span>There doesn't appear to be anything there.</span>
		@endif
	</div>

	

@stop