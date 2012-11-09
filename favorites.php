<html>

<?php include("include/head.html")
?>

<body>

		<script>
		$(document).ready(function() {

			// attach the plugin to an element
			$('#swipeMe li').swipeDelete({
				btnTheme: 'e',
				btnLabel: 'Delete',
				btnClass: 'aSwipeButton',
				click: function(e){
					e.preventDefault();
					var url = $(e.target).attr('href');
					//var id = url.substr(12);
					/*<?php
					include("include/config.php");
					mysql_query("DELETE FROM favorites WHERE DoctorId='$id' AND cookieName = '".$_COOKIE["name"]."'");
				
					
					?>*/
					$(this).parents('li').slideUp();
					$.post(url, function(data) {
						console.log(data);
					});
				}
			});

			$('#triggerMe').on('click', function(){
				$('#swipeMe li').trigger('swiperight')
			});

		});
		
	
				
	</script>
	
	
	
	

	<div data-role = "page" id = "fav">
		<div data-role = "header" data-theme = "b" data-position = "fixed">
			<h1> My Favorite Doctors </h1>
			<a data-rel = "back" data-role = "button" data-icon = "arrow-l" data-transition = "slide" data-theme = "a">Back </a>
			<a href = "index.php" data-role = "button" data-icon = "home" data-transition = "slide" data-theme = "a" data-direction="reverse"> Home </a>
		</div>
		
		<div data-role = "content">
			<?php include("include/favoriteFunctions.php"); ?>
			<ul id = "swipeMe" data-role = "listview" data-theme = "c">
				
				<?php addDoctors(); ?>
			</ul>

			<span id = "edit-buttons">
				<a href = "#" data-role = "button" data-theme = "b" data-type = "horizontal" data-inline = "true" id = "triggerMe"> Edit </a>
				<a href = "add.php" data-role = "button" data-theme = "b" data-transition = "slide" data-type = "horizontal" data-inline = "true"> Add </a>
			</span>
						

		</div>
	</div>

</body>
</html>