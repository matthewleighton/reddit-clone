@extends('layout')

@section('content')
	<div class="user-form">
		<h1 class="user-header">Login</h1>

		<form method="POST" action="/users/login">
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
			
			<input type="text" name="name" placeholder="Username" value="{{ session('name') }}" required>
			<input type="password" name="password" placeholder="Password" required>

			<button type="submit" class="user-submit">Login</button>
		</form>

		<br/>
		<p id="login-error">{{ session('error') }}</p>

	</div>
@stop