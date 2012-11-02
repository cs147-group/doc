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
			<ul data-role = "listview" data-theme = "c">
				<li>
					<a href = "profile.php?id=4" data-transition = "slide"> 
						<img src = "http://med.stanford.edu/profiles/viewImage?facultyId=17479&type=big&showNoImage=true&lastModified=1346976074900" class = "profilePic">
						<h3> Ira M. Friedman </h3> 
						<p> Phone: (650) 723-4841 <br> Hours: 9 am - 4 pm </p>
					</a> 
				</li>
			</ul>

			<span id = "edit-buttons">
				<a href = "" data-role = "button" data-theme = "b" data-type = "horizontal" data-inline = "true"> Edit </a>
				<a href = "add.php" data-role = "button" data-theme = "b" data-transition = "slide" data-type = "horizontal" data-inline = "true"> Add </a>
			</span>
						

		</div>
	</div>

</body>
</html>