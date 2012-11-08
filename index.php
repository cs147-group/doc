<?php
	/*
	 *  Redirect to index.php if the client opened root, since otherwise jQuery
	 *  mobile's AJAX page loading can cause all sorts of fun little bugs.
	 */
	$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	$pathFragments = explode('/', $path);
	$end = end($pathFragments);
	if ($end != "index.php") {
		header("Location: index.php");
		exit;
	}
?>

<!DOCTYPE html>

<html>

<?php include("include/head.html") ?>

<body>

	<div data-role = "page" id = "homepage">

		<div data-role = "content">
			<?php include("include/fav-link.html"); ?>

			<h1> Find Doc </h1>

			<form action = "search.php" method = "get" data-transition = "slide" id = "search-form">
				<input type = "search" name = "symptoms" placeholder = "Symptoms, e.g. cough" id = "symptomSearch" onclick = "$('.insuranceSearch').show(500)" required>
	    		<input name = "insurance" placeholder = "(optional) Your insurance" class = "insuranceSearch">
    			<input type = "submit" data-role = "button" data-theme = "b" data-icon = "arrow-r" data-transition = "slide" value = "Search">
    			<input class = "latitude" name = "latitude">
    			<input class = "longitude" name = "longitude">
    		</form>

			<p style = "text-align: center">
				Find a doctor, fast.
				<br>
				Just type in your symptoms!
			</p>

			<script>
				$("#homepage").live("pagebeforeshow", function() {
					if ($(".insuranceSearch").val() != "") {
						$('.insuranceSearch').show();
					}
				})

				$(".latitude").val("");
				$(".longitude").val("");
				<?php
					$id = "search-form";
					include("include/getcoords.php")
				?>
			</script>

		</div>

	</div>

</body>

</html>