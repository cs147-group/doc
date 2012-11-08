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

			<form style = "display: none">
				<input class = "latitude" name = "latitude">
				<input class = "longitude" name = "longitude">
			</form>

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
						echo "Phone: <a href='tel:+1".$row["phone"]."'>".$phone."</a><br>";
						echo "Hours: ".$row["hours"]."<br>";
						echo "Distance: <span class = 'distance'></span><br>";
						echo "</p></div>\n";
						echo "<span class = 'rating rating-profile'>".$row["rating"]."</span>";

						echo "<span class = 'profileButtons'>";
						echo "<a href= '#popupMap' data-rel='popup' data-role='button' data-inline='true'>Map</a>";
						
						
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
		<div data-role="popup" id="popupMap" data-overlay-theme="a" data-corners="false">
			<a data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-popup-btn-close">Close</a><img id = "mapImage" alt="Map">
		</div>
			<script>
				<?php include("include/stars.html") ?>

				function getDistance(data) {
					$.post("getdistance.php", data, function(data) {
						$(".distance").html(data);
					});
				}

				function setImage() {
					$("#mapImage").attr("src", function() {
						return "https://maps.googleapis.com/maps/api/staticmap?center=" + $(".latitude").val() + "+" + $(".longitude").val() +
							"&zoom=13&size=400x400&sensor=false";
					});
				}

				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(function (position) {
						$(".latitude").val(position.coords.latitude);
						$(".longitude").val(position.coords.longitude);
						getDistance({
							id: <?php echo $_GET["id"] ?>,
							latitude: position.coords.latitude,
							longitude: position.coords.longitude
						});
						setImage();
					}, function () {
						<?php
							if ($_SERVER['SERVER_NAME'] != "localhost") {
								$url = "http://api.ipinfodb.com/v3/ip-city/?key=16ceb4e81c46df1a31558904f1da1f79e2edabc509f4ec44bdc8c169fb71a193&format=xml&ip=".$_SERVER["REMOTE_ADDR"];
								$xml = simplexml_load_file($url);
								echo "$('.latitude').val(".$xml->latitude.");";
								echo "$('.longitude').val".$xml->longitude.");";
								echo "getDistance({";
									echo "id: ".$_GET["id"].",";
									echo "latitude: ".$xml->latitude.",";
									echo "longitude: ".$xml->longitude;
								echo "});";
							}
						?>
						setImage();
					});
				}
			</script>

		</div>
		<br>
	</div>

</body>
</html>