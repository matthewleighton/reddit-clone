@extends('layout')

@section('content')
	<div class="user-form">
		<p class="user-header">New User</p>

		<form method="POST">
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
			
			<input type="text" name="name" placeholder="Choose a username" value="{{ old('name') }}">
			<p class="user-error">{{ $errors->first('name') }}</p>

			<input type="password" name="password" placeholder="Password">
			<p class="user-error">{{ $errors->first('password') }}</p>
			
			<input type="password" name="password_confirmation" placeholder="Verify password">
			<p class="user-error">{{ $errors->first('password_confirmation') }}</p>

			<input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
			<p class="user-error">{{ $errors->first('email') }}</p>

			<br/>
			<button type="submit" class="user-submit">Sign up</button>
		</form>
	</div>
@stop