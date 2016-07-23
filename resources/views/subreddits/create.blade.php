@extends('layout')

@section('content')
	<div id="post-creation-form">
		<h1>Create a new subreddit</h1>

		<form method="POST">
		
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>

			<p class="input-title">Name</p>
			<p class="input-description">Choose a name for your subreddit for use in the url. (No spaces)</p>
			<input class="wide-field" type="text" name="name" placeholder="Name" value="{{ old('name') }}">
			<p class="user-error">{{ $errors->first('name') }}</p>
			
			<br/><br/>
			<button type="submit" class="user-submit">Create subreddit</button>
		</form>
	</div>
@stop