<html>

#Google Maps API code


    



<?php include("include/head.html") ?>



<body>

	<div data-role = "page" id = "profile<?php echo $_GET["id"] ?>">

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
						
						$latitude = $row["latitude"];
						$longitude = $row["longitude"];
						
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
						#echo "<a href= '#popupMap' data-rel='popup' data-role='button' data-theme = 'b' data-transition = 'pop' data-inline='true'>Map</a>";
						
						
						echo "<a href = '#ratePopup' data-rel = 'popup' data-role = 'button' data-theme = 'b' data-transition = 'pop' data-inline = 'true'> Rate </a>";
						echo "<a data-role = 'button' data-theme = 'b' data-transition = 'slide' data-inline = 'true' class = 'addToFavButton'> Fav </a>";
						echo "</span>\n";
?>



<body onload="initialize()" onunload="GUnload()">



    <div id="map_canvas" style="width: 500px; height: 300px"></div>
<?php
						echo "<h3 id = 'comments-title'> Comments </h3>";
						echo "<div class = 'comments-container'></div>";
					} else {
						echo "Not found.";
					}
				?>
			
    
      </body>
				
				
			</div>
			
			<div data-role="popup" id="popupMap" data-overlay-theme="a" data-corners="false">
				<img id = "mapImage" alt = "Map" src = "https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $row['latitude'].'+'.$row['longitude'] ?>&zoom=13&size=400x400&sensor=false">
				<a data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
							</div>

			<div data-role = "popup" data-overlay-theme = "a" id = "ratePopup">

				<a data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>

				<form id = "rate-form<?php echo $id ?>" action = "submit-rating.php" method = "post">
					<?php
						echo "<input name = 'id' value = '".$_GET["id"]."' style = 'display: none'>";
					?>
					<label for = "rating"> Rating (1 = poor, 5 = outstanding): </label>
					<input type = "range" name = "rating" min = "0" max = "5" data-highlight = "true" data-theme = "b" data-track-theme = "b" required>

					<label for = "comment"> Comments: </label>
					<textarea name = "comment" id = "comment"> </textarea>

					<span class = "rateButtons">
						<input type = "submit" value = "Submit" data-type = "horizontal" data-inline = "true" data-theme = "b">
						<a data-rel="back" data-role="button" data-theme="b" class="ui-btn-right">Cancel</a>
					</span>
				</form>
			</div>

			<script>
				<?php include("include/stars.html") ?>

				$("#profile<?php echo $id ?>").die("pagebeforeshow"); // Remove any previous bindings so that the code is not run twice

				$("#profile<?php echo $id ?>").live("pagebeforeshow", function() {
					$(".comments-container").html("");
					loadMoreComments(); // Calling the function also sets up the binding to loadMoreIfAtBottom

					$(".addToFavButton").click(function() {
						$.get("addToFav.php?id=<?php echo $id ?>", function(data) {
							$('.fav-link').effect("highlight", { color: "red" }, 3000);
						});
					});

					// Load more results if we are at the bottom
					function loadMoreComments() {
						$(window).unbind('scroll');
						$(".profile").append("<div class = 'loading'>Loading</div>");
						page = Math.ceil($(".comment").length / 10);
						$.get('loadMoreComments.php?id=<?php echo $id ?>&page=' + page, function(data) {
						 	if (data != "") {
								$(".comments-container").append(data);
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

					$("#rate-form<?php echo $id ?>").unbind("submit");

					$("#rate-form<?php echo $id ?>").submit(function() {
						$.post("submit-rating.php", $("#rate-form<?php echo $id ?>").serialize(), function() {
							<?php
								echo "window.location.href = 'profile.php?id=".$_GET["id"]."';\n"; // Go back
							?>
						});
						return false;
					});

					function getDistance(data) {
						$.post("getdistance.php", data, function(data) {
							$(".distance").html(data);
						});
					}

					if (navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(function (position) {
							$(".latitude").val(position.coords.latitude);
							$(".longitude").val(position.coords.longitude);
							var userLat = position.coords.latitude;
							var userLong = position.coords.latitude;
							#add the variables for the user's current location here
														
							getDistance({
								id: <?php echo $_GET["id"] ?>,
								latitude: position.coords.latitude,
								longitude: position.coords.longitude
							});
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
						});
					}
				});
				
				</script>
			<script type="text/javascript">

		

      function initialize() {
      	
        var mapOptions = {
          center: new google.maps.LatLng(<?php echo $latitude ?>, <?php echo $longitude ?>),
          zoom: 8,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"),
            mapOptions);
           var docCoords = new google.maps.LatLng(<?php echo $latitude?>,<?php echo $longitude?>);     	
           var docMarker = new google.maps.Marker({
          	position: docCoords, map: map, title: "Your doctor's location"});  
       
       		var userCoords = new google.maps.LatLng(userLat,userLong);
			
          	var userMarker = new google.maps.Marker({
          	position: userCoords, map: map, title: "Your location"});   
   
          	
      }
    </script>	
			

		</div>
		<br>
	</div>

</body>
</html>