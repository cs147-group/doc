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
						echo "<input type = 'search' name = 'symptoms' placeholder = 'Symptoms, e.g. cough' data-mini = 'true' id = 'symptomSearch' required value = '".$_GET["symptoms"]."' onclick = '$(\".insuranceSearch\").show(500)'>";
						echo "<input name = 'insurance' placeholder = '(optional) Your insurance' ";
						if ($_GET["insurance"] == "") echo "class = 'insuranceSearch'";
						else echo "value = '".$_GET["insurance"]."'";
						echo ">";
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
				<input type = "submit" data-role = "none" data-theme = "b" value = "Search" class = "results-search-button">
    		</form>

    		<br>

			<?php include("include/fav-link.html"); ?>

			<ul data-role = "listview" data-theme = "c" class = "search-ul" <?php if (!isset($_GET["doctor"])) echo "style = 'padding-top: 50px'" ?>>
			</ul>

			<br><br>

			<script>
				// Load more results if we are at the bottom
				function loadMoreResults(page) {
					$(window).unbind('scroll');
					$("#search").append("<div class = 'loading'>Loading</div>");
					if (page == -1) page = Math.ceil($("li").length / 10);
					$.get('loadMoreResults.php?param=<?php echo serialize($_GET); ?>&page=' + page, function(data) {
					 	if (data != "No results found.") {
							$(".search-ul").append(data);
							$(".search-ul").listview("refresh");
							$(".rating").stars();
							$(window).scroll(loadMoreResultsIfAtBottom);
						} else {
							if ($(".search-ul li").length == 0) {
								$(".search-ul").append("No results found.");
							}
						}
						$(".loading").remove();
					});
				}

				function loadMoreResultsIfAtBottom() {
					if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
						loadMoreResults(-1);
					}
				}

				loadMoreResults(0); // Calling the function also sets up the binding to loadMoreIfAtBottom

				$(document).ready(function() {
					$('.insuranceSearch').hide();
				});

				$('#search-form').click(function() {
				 	$('.insuranceSearch').fadeIn(500);
				});

				$("#rating, #distance").change(function() {
					$(this).closest("form").submit();
				});

				<?php include("include/stars.html") ?>
			</script>

		</div>

	</div>
</body>
</html>