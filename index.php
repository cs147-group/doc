<!DOCTYPE html>

<html>

<?php include("include/head.html") ?>

<body>

	<div data-role = "page" id = "homepage">

		<div data-role = "content">
			<?php include("include/fav-link.html"); ?>

			<h1> Find Doc </h1>

			<form action = "search.php" method = "get" data-transition = "slide">
				<input type = "search" name = "symptoms" placeholder = "Type in your symptoms here" required>
	    		<input type = "text" name = "insurance" placeholder = "(optional) Type your insurance here">
    			<input type = "submit" data-role="button" data-theme = "b" data-icon = "arrow-r" data-transition = "slide" value = "Search">
    		</form>

			<p style = "text-align: center">
				Find a doctor, fast.
				<br>
				Just type in your symptoms!
			</p>

		</div>

	</div>

</body>

</html>