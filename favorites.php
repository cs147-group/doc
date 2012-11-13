<html>

<?php include("include/head.html") ?>

<body>

	<div data-role = "page" id = "fav">
		<div data-role = "header" data-theme = "b" data-position = "fixed">
			<h1> My Favorite Doctors </h1>
			<a data-rel = "back" data-role = "button" data-icon = "arrow-l" data-transition = "slide" data-theme = "a">Back </a>
			<a href = "index.php" data-role = "button" data-icon = "home" data-transition = "slide" data-theme = "a" data-direction="reverse"> Home </a>
		</div>
		
		<div data-role = "content">
			<ul id = "swipeMe" data-role = "listview" data-theme = "c">
				<?php
					include("include/config.php");
					$query = "SELECT * FROM favorites WHERE userid = '".$_COOKIE["userid"]."'";
					$result = mysql_query($query);
					while ($fav = mysql_fetch_assoc($result)) {
						$query = "SELECT * FROM doctors WHERE id = '".$fav["doctorid"]."'";
						$row = mysql_fetch_assoc(mysql_query($query));
						include("include/phone.php");
						echo "<li data-swipeurl='a.php'>";
						echo "<a href = 'profile.php?id=".$row["id"]."' class = 'profile-link' data-transition='slide'>";
						echo "<img src = '".$row["image"]."' class = 'profilePic'>";
						echo "<span class = 'rating'>".$row["rating"]."</span>";
						echo "<h3> ".$row["name"]." </h3>";
						echo "<p>Phone: ".$phone."<br>";
						echo "Hours: ".$row["hours"]."<a data-role = 'button' data-theme = 'e' data-inline = 'true' id = 'deleteButton' hidden = 'true'> Delete </a> <br>";
						echo "</p></a></li>\n";
					}
				?>
			</ul>

			<span id = "edit-buttons">
				<a data-role = "button" data-theme = "b" data-type = "horizontal" data-inline = "true" id = "triggerMe"> Edit </a>
				<a href = "add.php" data-role = "button" data-theme = "b" data-transition = "slide" data-type = "horizontal" data-inline = "true"> Add </a>
			</span>

			<script>
				<?php include("include/stars.html") ?>

				// $(document).ready(function() {

				// 	$('#swipeMe li').swipeDelete({
				// 		btnTheme: 'e',
				// 		btnClass: 'deleteButton',
				// 		click: function(e) {
				// 				e.preventDefault();
				// 				$(this).parents('li').remove();
				// 			}
				// 	});

				// 	$('#swipeMe li').trigger('swiperight');
				// });

				$("#deleteButton").live ("vclick", function (event){
					$(this).parent().remove ();
				});
			</script>

		</div>
	</div>

</body>
</html>