@extends('layout')

@section('content')
	<div class="user-form">
		<h1 class="user-header">New User</h1>

		<form method="POST" action="/users/create">
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
			
			<input type="text" name="name" placeholder="Choose a username" value="{{ old('name') }}" autofocus autocomplete="off">
			<p class="user-error">{{ $errors->first('name') }}</p>

			<input type="password" name="password" placeholder="Password">
			<p class="user-error">{{ $errors->first('password') }}</p>
			
			<input type="password" name="password_confirmation" placeholder="Verify password">
			<p class="user-error">{{ $errors->first('password_confirmation') }}</p>

			<input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
			<p class="user-error">{{ $errors->first('email') }}</p>

			
			<button type="submit" class="user-submit">Sign up</button>
		</form>
	</div>
@stop