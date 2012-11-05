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
				function getDistance(data) {
					$.post("getdistance.php", data, function(data) {
						$(".distance").html(data);
					});
				}
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(function (position) {
						getDistance({
							id: <?php echo $_GET["id"] ?>,
							latitude: position.coords.latitude,
							longitude: position.coords.longitude
						});
					}, function () {
						getDistance({
							id: <?php echo $_GET["id"] ?>,
							<?php
								$url = "http://api.ipinfodb.com/v3/ip-city/?key=16ceb4e81c46df1a31558904f1da1f79e2edabc509f4ec44bdc8c169fb71a193&format=xml&ip=".$_SERVER["REMOTE_ADDR"];
								$xml = simplexml_load_file($url);
								echo "latitude: ".$xml->latitude.",";
								echo "longitude: ".$xml->longitude;
							?>
						});
					});
				}
			</script>

		</div>
		<br>
	</div>

</body>
</html>