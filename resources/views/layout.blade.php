<!DOCTYPE html>
<html>
<head>
	<title>Laravel Reddit Clone</title>
	
	<!--<script   src="https://code.jquery.com/jquery-3.1.0.min.js" integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s=" crossorigin="anonymous"></script>
	<script type="text/javascript" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">-->

	<!--<script type="text/javascript" src="/js/bootstrap.min.js"></script>-->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="/js/main.js"></script>
	
	<link rel="stylesheet" type="text/css" href="/css/app.css">
	<link href="https://fonts.googleapis.com/css?family=Cabin:400,700" rel="stylesheet">

</head>
<body>
	<div id="wrapper">
		<div class="navbar">
			<div class="navbar-left navbar-element">
				<a href="/" id="header-logo">Laravel Reddit Clone</a>
			</div>
			<div class="navbar-center navbar-element">
				@yield('header-center')
			</div>
			<div class="navbar-right navbar-element">
				@if (Auth::user()['name'])
					Hello, {{ Auth::user()['name'] }} | <a href="/users/logout">Logout</a>
				@else
					<a href="/users/new">Register</a> | <a href="/users/login">Login</a>
				@endif
			</div>
		</div>

		<div class="container">
			@yield('content')
		</div>
	</div>
</body>
</html>