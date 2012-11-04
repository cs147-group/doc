<html>

<?php include("include/head.html") ?>

<body>

	<div data-role = "page" id = "add">
		<div data-role = "header" data-theme = "b" data-position = "fixed">
			<h1> Add a doctor </h1>
			<a data-rel = "back" data-role = "button" data-icon = "arrow-l" data-transition = "slide" data-theme = "a">Back </a>
			<a href = "index.php" data-role = "button" data-icon = "home" data-transition = "slide" data-theme = "a" data-direction="reverse"> Home </a>
		</div>

		<div data-role = "content">
			<?php include("include/fav-link.html"); ?>
			<h1 id = "add-fav-title"> Add a favorite doctor: </h1>
			<form action = "search.php" method = "get" data-transition = "slide" id = "add-form">
				<input type = "search" name = "doctor" placeholder = "Type in a doctor's name" required>
				<input type = "submit" data-role="button" data-theme = "b" data-icon = "arrow-r" data-transition = "slide" value = "Search">
				<input class = "latitude" name = "latitude">
    			<input class = "longitude" name = "longitude">
			</form>

			<script>
				$(".latitude").val("");
				$(".longitude").val("");
				<?php
					$id = "add-form";
					include("include/getcoords.php")
				?>
			</script>
		</div>

	</div>
</body>
</html>