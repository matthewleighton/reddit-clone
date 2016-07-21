@extends('layout')

@section('content')
	
	@include('posts.post-title')

	<div class="comments-section">
		<form method="POST">
			<textarea placeholder="Post a comment"></textarea>
			<button type="submit">Save</button>
		</form>
	</div>

@stop