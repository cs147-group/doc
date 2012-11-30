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

	if (!isset($_COOKIE["userid"])) {
		$date_of_expiry = time() + (10 * 365 * 24 * 60 * 60);
		setCookie("userid" , "user", $date_of_expiry);
	}
?>

<!DOCTYPE html>

<html>

<?php include("include/head.html") ?>

<body>

	<div data-role = "page" id = "homepage">

		<div data-role = "content">
			<?php include("include/fav-link.html"); ?>

			
			<img src = "Doc.png" alt = "Doc" class = "center">
			<form action = "search.php" method = "get" data-transition = "slide" id = "search-form">
				<input type = "search" name = "symptoms" placeholder = "Symptoms, e.g. cough" class = "symptomSearch" onclick = "$('.insuranceSearch').show(500)" required>
				<ul class = "symptomSuggestions" data-role="listview" data-inset="true"></ul>
				<div class = "noResultsFound"></div>
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
				$("#homepage").bind("pageshow", function() {
					$(".symptomSearch").autocomplete({
						target: $('.symptomSuggestions'),
						source: "suggestions.php",
						minLength: 1,
						callback: function(e) {
							var $a = $(e.currentTarget); // access the selected item
							var right = $a.offset().left + $a.width() + 50;
							$('.symptomSearch').val($a.text()); // place the value of the selection into the search box
							$(".symptomSearch").autocomplete('clear'); // clear the listview
							if (e.pageX < right) { // clicked list element, not fill arrow
								$("#search-form").submit();
							}
						},
						loadingHtml: ''
					});
				});

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