<html>

<?php include("include/head.html") ?>

<body>

	<div data-role = "page" id = "rate">
		<div data-role = "header" data-theme = "b" data-position = "fixed">
			<h1> Rate </h1>
			<a id = "back" data-rel = "back" data-role = "button" data-icon = "arrow-l" data-transition = "slide" data-theme = "a"> Back </a>
			<a href = "index.php" data-role = "button" data-icon = "home" data-transition = "slide" data-theme = "a" data-direction = "reverse"> Home </a>
		</div>

		<div data-role = "content">
			<?php include("include/fav-link.html"); ?>

			<form id = "form" action = "submit-rating.php" method = "post" data-ajax="false">
				<?php
					echo "<input name = 'id' value = '".$_GET["id"]."' style = 'display: none'>";
				?>
				<label for = "rating"> Rating (1 = poor, 5 = outstanding): </label>
				<input type = "range" name = "rating" min = "0" max = "5" data-highlight = "true" data-theme = "b" data-track-theme = "b" required>

				<label for = "comment"> Comments: </label>
				<textarea name = "comment" id = "comment"> </textarea>

				<span class = "rateButtons">
					<input type = "submit" value = "Submit" data-type = "horizontal" data-inline = "true" data-theme = "b">
					<a data-rel = "back"> <input type = "button" value = "Cancel" data-type = "horizontal" data-inline = "true" data-theme = "b"> </a>
				</span>
			</form>
		</div>


		<script type="text/javascript">
			window.onload = $("#form").submit(function() {
				$.post("submit-rating.php", $("#form").serialize(), function() {
					<?php
						echo "window.location.href = 'profile.php?id=".$_GET["id"]."';\n"; // Go back
					?>
				});
				return false;
			});
		</script>

	</div>
</body>
</html>