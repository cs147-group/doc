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
						echo "<li data-swipeurl='removeFromFav.php?id=".$row["id"]."'>";
						echo "<a href = 'profile.php?id=".$row["id"]."' class = 'profile-link' data-transition='slide'>";
						echo "<img src = '".$row["image"]."' class = 'profilePic'>";
						echo "<span class = 'rating'>".$row["rating"]."</span>";
						echo "<h3> ".$row["name"]." </h3>";
						echo "<p>Phone: ".$phone."<br>";
						echo "Hours: ".$row["hours"]."<br>";
						echo "</p></a>";
						echo "</li>\n";
					}
				?>
			</ul>

			<span id = "edit-buttons">
				<a data-role = "button" data-theme = "b" data-type = "horizontal" data-inline = "true" onclick = "edit()" id = "editButton"> Edit </a>
				<a href = "add.php" data-role = "button" data-theme = "b" data-transition = "slide" data-type = "horizontal" data-inline = "true" id = "addButton"> Add </a>
			</span>

			<script>
				<?php include("include/stars.html") ?>

				var params = {
					btnTheme: 'e',
					click: function(e) {
							$.get($(this).parents('li').attr('data-swipeurl'));
							$(this).parents('li').remove();
							$('ul').listview('refresh');
							return false;
						}
				};

				$("#fav").live("pageinit", function() {
					$('#swipeMe li').swipeDelete(params);
				});

				function edit() {
					if ($("#editButton span span").text() == "Done") {
						$('.aSwipeBtn').animate({ width: 'toggle' }, 200, function(e) {
							$(this).remove();
						});
						$('#swipeMe li').swipeDelete(params);
						$("#editButton span span").text("Edit");
					} else {
						$('#swipeMe li').off('swiperight');
						$('#swipeMe li:not(:has(.aSwipeBtn))').filter('[data-swipeurl]').each(function(i, el) {
							var $e = $(el);
							if ($e);
							var $parent = $(el).parent('ul');
							var $li = $e;
							var $swipeBtn = $('<a> Delete </a>').attr({
											'data-role': 'button',
											'data-mini': true,
											'data-inline': 'true',
											'class': 'aSwipeBtn',
											'data-theme': params.btnTheme,
											'href': $li.data('swipeurl')
										})
										.on('click tap', params.click);

						// slide insert button into list item
						$swipeBtn.prependTo($li).button();
						$li.find('.ui-btn').hide().animate({ width: 'toggle' }, 200);
						});
						$("#editButton span span").text("Done");
					}
				}
			</script>

		</div>
	</div>

</body>
</html>