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
						echo "<a href= '#popupMap' data-rel='popup' data-role='button' data-theme = 'b' data-transition = 'pop' data-inline='true'>Map</a>";
						
						
						echo "<a href = '#ratePopup' data-rel = 'popup' data-role = 'button' data-theme = 'b' data-transition = 'pop' data-inline = 'true'> Rate </a>";
						echo "</span>\n";

						echo "<h3 id = 'comments-title'> Comments </h3>";
						echo "<div id = 'comments-container'></div>";
					} else {
						echo "Not found.";
					}
				?>
				
				
				
			</div>

        	<div data-role="popup" id="popupMap" data-overlay-theme="a" data-corners="false">
        		<img id = "mapImage" alt="Map">
        		<a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
        	</div>

			<div data-role = "popup" data-overlay-theme = "a" id = "ratePopup">

				<a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>

				<form id = "rate-form" action = "submit-rating.php" method = "post" data-ajax="false">
					<?php
						echo "<input name = 'id' value = '".$_GET["id"]."' style = 'display: none'>";
					?>
					<label for = "rating"> Rating (1 = poor, 5 = outstanding): </label>
					<input type = "range" name = "rating" min = "0" max = "5" data-highlight = "true" data-theme = "b" data-track-theme = "b" required>

					<label for = "comment"> Comments: </label>
					<textarea name = "comment" id = "comment"> </textarea>

					<span class = "rateButtons">
						<input type = "submit" value = "Submit" data-type = "horizontal" data-inline = "true" data-theme = "b">
						<a data-rel = "back" id = "rate-cancel"> <input type = "button" value = "Cancel" data-type = "horizontal" data-inline = "true" data-theme = "b"> </a>
					</span>
				</form>
			</div>

		<script>
		</script>

			<script>
				<?php include("include/stars.html") ?>

				// Load more results if we are at the bottom
				function loadMoreComments() {
					$(window).unbind('scroll');
					$("#profile").append("<div class = 'loading'>Loading</div>");
					page = Math.ceil($(".comment").length / 10);
					$.get('loadMoreComments.php?id=<?php echo $id ?>&page=' + page, function(data) {
					 	if (data != "") {
							$("#comments-container").append(data);
							$(window).scroll(loadMoreCommentsIfAtBottom);
						}
						$(".loading").remove();
					});
				}

				function loadMoreCommentsIfAtBottom() {
					if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
						loadMoreComments();
					}
				}

				loadMoreComments(); // Calling the function also sets up the binding to loadMoreIfAtBottom

				$("#rate-form").submit(function() {
					$.post("submit-rating.php", $("#rate-form").serialize(), function() {
						alert(data);
						$("#rate-cancel").click();
						// Reload the comments
						$("#comments-container").html("")
						loadMoreComments();
					});
					return false;
				});

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
								echo "$('.longitude').val(".$xml->longitude.");";
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