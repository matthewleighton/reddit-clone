<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Laravel Reddit Clone</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="{{ appRoot() }}js/main.js"></script>
	
	<link rel="stylesheet" type="text/css" href="{{ appRoot() }}css/app.css">
	<!--<link href="https://fonts.googleapis.com/css?family=Cabin:400,700" rel="stylesheet">-->
	<link rel="shortcut icon" type="image/png" href="{{ appRoot() }}img/logo.png"/>
</head>
<body>
	<div id="wrapper">
		<div class="navbar">
			<div class="navbar-left navbar-element">
				<a href="{{ appRoot() }}" id="header-logo"><img src="{{ appRoot() }}img/logo.png" class="header-logo">Laravel Reddit Clone</a> 
				@if (isset($subreddit) && $subreddit)
					<a href="{{ appRoot() }}r/{{ $subreddit['name'] }}" class="subreddit-title">{{ $subreddit['name'] }}</a>
				@endif
			</div>
				
			@if (Auth::user())
				<div clas="view-by-right">
					<a href="{{ appRoot() }}">All Subreddits</a> | <a href="{{ appRoot() }}subscriptions">My Subscriptions</a>
				</div>
			@endif
			
			<div class="navbar-right navbar-element">
				@if (Auth::user()['name'])
					Hello, {{ Auth::user()['name'] }} | <a href="{{ appRoot() }}users/logout">Logout</a>
				@else
					<a href="{{ appRoot() }}users/new">Register</a> | <a href="{{ appRoot() }}users/login">Login</a>
				@endif
			</div>
		</div>

		<div class="container">
			@yield('content')
		</div>
	</div>
</body>
</html>