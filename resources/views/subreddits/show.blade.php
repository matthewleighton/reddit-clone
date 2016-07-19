@extends('layout')

@section('header-center')
	<div>View by</div>
	<div><a href="#">Top</a> | <a href="#">New</a></div>
@stop


@section('content')
	<div class="time-selector">Links from</div>

	<div>
		This is the list of posts<br/>
		{{ $data['time'] }}<br/><br/>

		@foreach ($data['posts'] as $post)		
			<p><a href="#" class="post-link">{{ $post->title }}</a></p>
		@endforeach
		
	</div>
@stop