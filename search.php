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

			<form action = "search.php" method = "get">
				<?php
					if (!isset($_GET["doctor"])) {
						echo "<input type = 'search' name = 'symptoms' placeholder = 'Type in your symptoms here' required value = '".$_GET["symptoms"]."'>";
					} else {
						echo "<input type = 'search' name = 'doctor' placeholder = 'Type in a doctor's name' required value = '".$_GET["doctor"]."'>";
					}
				?>
    			<input type = "submit" data-role="button" data-theme = "b" data-icon = "arrow-r" value = "Search">
    		</form>

			<br><br>

			<?php include("include/fav-link.html"); ?>

			<ul data-role = "listview" data-theme = "c">

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
							$query = "SELECT * FROM doctors WHERE specialties = '".$row["specialty"]."' AND insurance LIKE '%{$insurance}%' ORDER BY rating DESC LIMIT 0, 10";
							$result = mysql_query($query);
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
						} else {
							echo "No results found.";
						}
					} else {
						$query = "SELECT * FROM doctors WHERE name LIKE '%{$doctor}%' ORDER BY name LIMIT 0, 10";
						$result = mysql_query($query);
						if ($result && mysql_num_rows($result) != 0) {
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
						} else {
							echo "No results found.";
						}
					}
				?>

			</ul>

			<br><br>

		</div>

	</div>
</body>
</html>