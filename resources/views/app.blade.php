<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>App</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
	<link rel="stylesheet" href="/css/app.css">
</head>
<body>
	<div id="app" class="antialiased text-gray-800 container mx-auto h-screen flex">
		<navbar></navbar>
		<div class="w-1/2 border-l border-r overflow-auto feed">
			<transition name="router-view" mode="out-in">
				<router-view></router-view>
			</transition>
		</div>
		<sidebar></sidebar>
	</div>
	<script src="/js/app.js"></script>
</body>
</html>