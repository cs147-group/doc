<html>

<?php include("include/head.html") ?>

<body>

	<div data-role = "page" id = "search">

		<div data-role = "header" data-theme = "b" data-position = "fixed">
			<h1> Search Results </h1>
			<a data-rel = "back" data-role = "button" data-icon = "arrow-l" data-transition = "slide" data-theme = "a">Back </a>
			<a href = "index.php" data-role = "button" data-icon = "home" data-transition = "slide" data-theme = "a" data-direction="reverse"> Home </a>
		</div>

		<div data-role = "content">

			<form action = "search.php" method = "get" id = "search-form" style = "margin-bottom: 0">
				<?php
					if (!isset($_GET["doctor"])) {
						echo "<input type = 'search' name = 'symptoms' placeholder = 'Type in your symptoms here' data-mini = 'true' required value = '".$_GET["symptoms"]."'>";
						?>
						<fieldset data-role= "controlgroup" data-type = "horizontal" data-role = "fieldcontain" style = "float: right">
							<legend> Sort by: </legend>
							<input type = "radio" name = "sort" data-mini = "true" value = "rating" id = "rating" <?php if ($_GET["sort"] != "distance") echo "checked" ?>>
							<label for = "rating"> Rating </label>
							<input type = "radio" name = "sort" data-mini = "true" value = "distance" id = "distance" <?php if ($_GET["sort"] == "distance") echo "checked" ?>>
							<label for = "distance"> Distance </label>
						</fieldset>
						<?php
					} else {
						echo "<input type = 'search' name = 'doctor' placeholder = 'Type in a doctor's name' data-mini = 'true' required value = '".$_GET["doctor"]."'>";
					}
				?>
				<input class = "latitude" name = "latitude" value = <?php echo $_GET["latitude"] ?>>
    			<input class = "longitude" name = "longitude" value = <?php echo $_GET["longitude"] ?>>
				<input type = "submit" data-role="button" data-theme = "b" value = "Search">
    		</form>

    		<br>

			<?php include("include/fav-link.html"); ?>

			<ul data-role = "listview" data-theme = "c" <?php if (!isset($_GET["doctor"])) echo "style = 'padding-top: 50px'" ?>>
			</ul>

			<br><br>

			<script>
				// Load more results if we are at the bottom
				function loadMoreResults() {
					$(window).unbind('scroll');
					$("#search").append("<div class = 'loading'>Loading</div>");
					page = Math.ceil($("li").length / 10);
					$.get('loadMoreResults.php?param=<?php echo serialize($_GET); ?>&page=' + page, function(data) {
					 	if (data != "No results found.") {
							$("ul").append(data);
							$("ul").listview("refresh");
							$(".rating").stars();
							$(window).scroll(loadMoreResultsIfAtBottom);
						} else {
							if ($("ul li").length == 0) {
								$("ul").append("No results found.");
							}
						}
						$(".loading").remove();
					});
				}

				function loadMoreResultsIfAtBottom() {
					if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
						loadMoreResults();
					}
				}

				loadMoreResults(); // Calling the function also sets up the binding to loadMoreIfAtBottom

				$("#rating, #distance").change(function() {
					$(this).closest("form").submit();
				});

				<?php include("include/stars.html") ?>
			</script>

		</div>

	</div>
</body>
</html>