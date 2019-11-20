<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Intra Tuteurs</title>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.2.3/dist/css/uikit.min.css" />
	<link rel="stylesheet" href="assets/css/app.css" />
</head>
<body>
	
	<div uk-grid class="uk-grid-collapse">

		<div class="uk-width-1-6@s sidebarDashboard">
			@include('includes.sidebar')
		</div>
		
		<div class="uk-width-1-6@s main-dashboard">
		</div>
		<div class="uk-width-5-6@s main-dashboard">
			<div class="navbarDashboard">
				@include('includes.navDashboard')
			</div>
			<div class="content">
				@yield('content')
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/uikit@3.2.3/dist/js/uikit.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/uikit@3.2.3/dist/js/uikit-icons.min.js"></script>
</body>
</html>