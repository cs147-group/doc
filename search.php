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

			
				<?php
					include("include/config.php");
					$doctor = $_GET["doctor"];
					if (!isset($doctor)) { // doctor is empty, so they probably searched for symptoms
						$symptoms = $_GET["symptoms"];
						$query = "SELECT * FROM symptoms WHERE symptoms = '".$symptoms."'";
						$result = mysql_query($query);
						if ($result && mysql_num_rows($result) != 0) {
							$row = mysql_fetch_assoc($result);
							$insurance = $_GET["insurance"];
							if ($_GET["sort"] == "distance") {
								$order = "distance";
							} else {
								$order = "rating DESC";
							}
							$query = "SELECT *, ( 3959 * acos( cos( radians(".$_GET["latitude"].") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(".$_GET["longitude"].") ) + sin( radians(".$_GET["latitude"].") ) * sin( radians( latitude ) ) ) ) AS distance ".  // From https://developers.google.com/maps/articles/phpsqlsearch_v3
							"FROM doctors WHERE specialties = '".$row["specialty"]."' AND insurance LIKE '%{$insurance}%' HAVING distance < 30 ORDER BY ".$order." LIMIT 0, 10";
							$result = mysql_query($query);
							if (mysql_num_rows($result) == 0) { // Try and find doctors within 100 miles
								$query = "SELECT *, ( 3959 * acos( cos( radians(".$_GET["latitude"].") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(".$_GET["longitude"].") ) + sin( radians(".$_GET["latitude"].") ) * sin( radians( latitude ) ) ) ) AS distance ".  // From https://developers.google.com/maps/articles/phpsqlsearch_v3
								"FROM doctors WHERE specialties = '".$row["specialty"]."' AND insurance LIKE '%{$insurance}%' HAVING distance < 100 ORDER BY ".$order." LIMIT 0, 10";
								$result = mysql_query($query);
								if (mysql_num_rows($result) == 0) {
									echo "No results found.";
								} else {
									echo "<div class = 'wrapper'><div class = 'hide'>Your search distance has been expanded</div></div>";
								}
							}
							if (mysql_num_rows($result) != 0) {
								?>
								<ul data-role = "listview" data-theme = "c" <?php if (!isset($_GET["doctor"])) echo "style = 'padding-top: 50px'" ?>>
								<?php
								while ($row = mysql_fetch_assoc($result)) {
									include("include/phone.php");
									echo "<li>";
									echo "<a href = 'profile.php?id=".$row["id"]."' class = 'profile-link' data-transition='slide'>";
									echo "<img src = '".$row["image"]."' class = 'profilePic'>";
									echo "<span class = 'rating'>".$row["rating"]."</span>";
									echo "<h3> ".$row["name"]." </h3>";
									echo "<p>Phone: ".$phone."<br>";
									echo "Hours: ".$row["hours"]."<br>";
									echo "</p></a></li>\n";
								}
							}
						} else {
							echo "No results found.";
						}
					} else {
						$query = "SELECT *, ( 3959 * acos( cos( radians(".$_GET["latitude"].") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(".$_GET["longitude"].") ) + sin( radians(".$_GET["latitude"].") ) * sin( radians( latitude ) ) ) ) AS distance ".  // From https://developers.google.com/maps/articles/phpsqlsearch_v3
						"FROM doctors WHERE name LIKE '%{$doctor}%' HAVING distance < 30 ORDER BY name LIMIT 0, 10";
						$result = mysql_query($query);
						if (mysql_num_rows($result) == 0) { // Try and find doctors, regardless of distance
							$query = "SELECT *, ( 3959 * acos( cos( radians(".$_GET["latitude"].") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(".$_GET["longitude"].") ) + sin( radians(".$_GET["latitude"].") ) * sin( radians( latitude ) ) ) ) AS distance ".  // From https://developers.google.com/maps/articles/phpsqlsearch_v3
							"FROM doctors WHERE name LIKE '%{$doctor}%' ORDER BY name LIMIT 0, 10";
							$result = mysql_query($query);
							if (mysql_num_rows($result) == 0) {
								echo "No results found.";
							} else {
								echo "<div class = 'wrapper'><div class = 'hide'>We couldn't find a doctor within 30 mi</div></div>";
							}
						}
						if (mysql_num_rows($result) != 0) {
							?>
							<ul data-role = "listview" data-theme = "c" <?php if (!isset($_GET["doctor"])) echo "style = 'padding-top: 50px'" ?>>
							<?php
							while ($row = mysql_fetch_assoc($result)) {
								include("include/phone.php");
								echo "<li>";
								echo "<a href = 'profile.php?id=".$row["id"]."' class = 'profile-link' data-transition='slide'>";
								echo "<img src = '".$row["image"]."' class = 'profilePic'>";
								echo "<h3> ".$row["name"]." </h3>";
								echo "<p> Rating: ".round($row["rating"], 1)."<br>";
								echo "Phone: ".$phone."<br>";
								echo "Hours: ".$row["hours"]."<br>";
								echo "</p></a></li>\n";
							}
						}
					}
				?>
			</ul>

			<br><br>

			<script>
				$("#rating, #distance").change(function() {
	 				$(this).closest("form").submit();
				});

				<?php include("include/stars.html") ?>
			</script>

		</div>

	</div>
</body>
</html>