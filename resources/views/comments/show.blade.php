@extends('layout')

@section('content')
	
	@include('posts.post-title')

	@if ('$post->textpost')
		<span>This is a textpost</span>
	@endif

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