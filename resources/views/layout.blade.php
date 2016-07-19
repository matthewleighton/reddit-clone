<!DOCTYPE html>
<html>
<head>
	<title>Not Reddit</title>
	
	<!--<script   src="https://code.jquery.com/jquery-3.1.0.min.js" integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s=" crossorigin="anonymous"></script>
	<script type="text/javascript" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">-->

	<!--<script type="text/javascript" src="/js/bootstrap.min.js"></script>-->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="/css/app.css">
	<link href="https://fonts.googleapis.com/css?family=Cabin:400,700" rel="stylesheet">

</head>
<body>
	<div id="wrapper">
		<div class="navbar">
			<div class="navbar-left navbar-element">
				<a href="/" id="header-logo">Reddit</a>
			</div>
			<div class="navbar-center navbar-element">
				@yield('header-center')
			</div>
			<div class="navbar-right navbar-element">
				<a href="/users/create">Register</a> | <a href="#">Login</a>
			</div>
		</div>

		<div class="container">
			@yield('content')
		</div>
	</div>
</body>
</html>