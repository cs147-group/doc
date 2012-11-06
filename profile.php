<html>

<?php include("include/head.html") ?>

<body>

	<div data-role = "page" id = "profile">

		<div data-role = "header" data-theme = "b" data-position = "fixed">
			<h1> Doctor Profile </h1>
			<a data-rel = "back" data-role = "button" data-icon = "arrow-l" data-transition = "slide" data-theme = "a">Back </a>
			<a href = "index.php" data-role = "button" data-icon = "home" data-transition = "slide" data-theme = "a" data-direction="reverse"> Home </a>
		</div>

		<div data-role = "content">
			<?php include("include/fav-link.html"); ?>

			<div class = "businessCard">
				<?php
					include("include/config.php");
					$id = $_GET["id"];
					$query = "SELECT * FROM doctors WHERE id = '".$id."'";
					$result = mysql_query($query);
					if ($result && mysql_num_rows($result) != 0) {
						$row = mysql_fetch_assoc($result);
						include("include/phone.php");
						echo "<h3> ".$row["name"]." </h3>";
						echo "<div class = 'doctor-details'>";
						echo "<img src = '".$row["image"]."'>";
						echo "<p> Specialty: ".$row["specialties"]."<br>";
						echo "Rating: ".round($row["rating"], 1)."<br>";
						echo "Phone: <a href='tel:+1".$row["phone"]."'>".$phone."</a><br>";
						echo "Hours: ".$row["hours"]."<br>";
						echo "Distance: <span class = 'distance'></span><br>";
						echo "</p></div>\n";

						echo "<span class = 'profileButtons'>";
						echo "<a href = 'http://maps.google.com/?q=".$row["latitude"].",".$row["longitude"]."' data-role = 'button' data-theme = 'b' data-type = 'horizontal' data-inline = 'true'> Map </a>";
						
						<a href="#popupBasic" data-transition="flip" data-rel="popup">Map</a>
							<iframe src="http://maps.google.com/?q=".$row["latitude"].",".$row["longitude"]" width="497" height="298" seamless></iframe>
						<div data-role="popup" id="popupBasic">
						</div>

						
						
						
						
						echo "<a href = 'rate.php?id=".$row["id"]."' data-role = 'button' data-theme = 'b' data-transition = 'slide' data-type = 'horizontal' data-inline = 'true'> Rate </a>";
						echo "</span>\n";

						echo "<h3 id = 'comments-title'> Comments </h3>";
						$query = "SELECT * FROM ratings WHERE id = '".$id."' ORDER BY date DESC LIMIT 0, 10";
						$result = mysql_query($query);
						if ($result) {
							while ($row = mysql_fetch_assoc($result)) {
								echo "<p class = 'comment'> Rating: ".$row["rating"]."<br>";
								echo $row["comment"]."<hr>";
							}
						}
					} else {
						echo "Not found.";
					}
				?>
			</div>

			<script>
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(function (position) {
						$.post("getdistance.php", {
							id: <?php echo $_GET["id"] ?>,
							latitude: position.coords.latitude,
							longitude: position.coords.longitude
						}, function(data) {
							$(".distance").html(data);
						})
					});
				}
			</script>

		</div>
		<br>
	</div>

</body>
</html>