@extends('layout')

@section('content')
	<div class="navbar navbar-default">
		<a class="navbar-brand" href="#">Reddit Clone</a>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li class="active"><a href="#">Top<span class="sr-only">(current)</span></a></li>
			</ul>
		</div>
	</div>

	<div>
		This is the list of posts<br/>
		{{ $data['time'] }}<br/><br/>

		@foreach ($data['posts'] as $post)		
			<p>{{ $post->title }}</p>
		@endforeach
		
	</div>
@stop