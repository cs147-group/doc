<?php
	include("include/config.php");
	$page = $_GET["page"];
	$_GET = unserialize($_GET["param"]);
	$from = $page * 10;
	$to = ($page + 1) * 10;
	$ignore = FALSE;

	$doctor = $_GET["doctor"];
	if (!isset($doctor)) { // doctor is empty, so they probably searched for symptoms
		$symptoms = $_GET["symptoms"];
		$query = "SELECT * FROM symptoms WHERE symptoms = '".$symptoms."'";
		$result = mysql_query($query);
		if (mysql_num_rows($result) != 0) {
			$row = mysql_fetch_assoc($result);
			$insurance = $_GET["insurance"];
			if ($_GET["sort"] == "distance") {
				$order = "distance";
			} else {
				$order = "rating DESC";
			}
			if ($from == 0) echo "<div class = 'search-info'> We searched for ".$row["specialty"]."s ";
			$query = "SELECT *, ( 3959 * acos( cos( radians(".$_GET["latitude"].") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(".$_GET["longitude"].") ) + sin( radians(".$_GET["latitude"].") ) * sin( radians( latitude ) ) ) ) AS distance ".  // From https://developers.google.com/maps/articles/phpsqlsearch_v3
			"FROM doctors WHERE specialties = '".$row["specialty"]."' AND insurance LIKE '%{$insurance}%' HAVING distance < 30 ORDER BY ".$order." LIMIT ".$from.", ".$to;
			$result = mysql_query($query);
			if (mysql_num_rows($result) == 0) { // Try and find doctors within 100 miles
				if ($from != 0) {
					$from = 0;
					$to = 10;
					$query = "SELECT *, ( 3959 * acos( cos( radians(".$_GET["latitude"].") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(".$_GET["longitude"].") ) + sin( radians(".$_GET["latitude"].") ) * sin( radians( latitude ) ) ) ) AS distance ".  // From https://developers.google.com/maps/articles/phpsqlsearch_v3
					"FROM doctors WHERE specialties = '".$row["specialty"]."' AND insurance LIKE '%{$insurance}%' HAVING distance < 30 ORDER BY ".$order." LIMIT ".$from.", ".$to;
					$result = mysql_query($query);
					$ignore = TRUE;
				}
				if (mysql_num_rows($result) == 0) {
					$query = "SELECT *, ( 3959 * acos( cos( radians(".$_GET["latitude"].") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(".$_GET["longitude"].") ) + sin( radians(".$_GET["latitude"].") ) * sin( radians( latitude ) ) ) ) AS distance ".  // From https://developers.google.com/maps/articles/phpsqlsearch_v3
					"FROM doctors WHERE specialties = '".$row["specialty"]."' AND insurance LIKE '%{$insurance}%' HAVING distance < 100 ORDER BY ".$order." LIMIT ".$from.", ".$to;
					$result = mysql_query($query);
					if (mysql_num_rows($result) != 0) {
						if ($from == 0) echo "within 100 miles. </div>";
					}
				}
			} else {
				if ($from == 0) echo "within 30 miles. </div>";
			}
		}
	} else {
		$query = "SELECT *, ( 3959 * acos( cos( radians(".$_GET["latitude"].") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(".$_GET["longitude"].") ) + sin( radians(".$_GET["latitude"].") ) * sin( radians( latitude ) ) ) ) AS distance ".  // From https://developers.google.com/maps/articles/phpsqlsearch_v3
		"FROM doctors WHERE name LIKE '%{$doctor}%' HAVING distance < 30 ORDER BY name LIMIT ".$from.", ".$to;
		$result = mysql_query($query);
		if (mysql_num_rows($result) == 0) { // Try and find doctors, regardless of distance
			if ($from != 0) {
				$from = 0;
				$to = 10;
				$query = "SELECT *, ( 3959 * acos( cos( radians(".$_GET["latitude"].") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(".$_GET["longitude"].") ) + sin( radians(".$_GET["latitude"].") ) * sin( radians( latitude ) ) ) ) AS distance ".  // From https://developers.google.com/maps/articles/phpsqlsearch_v3
				"FROM doctors WHERE name LIKE '%{$doctor}%' HAVING distance < 30 ORDER BY name LIMIT ".$from.", ".$to;
				$result = mysql_query($query);
				$ignore = TRUE;
			}
			if (mysql_num_rows($result) == 0) {
				$query = "SELECT *, ( 3959 * acos( cos( radians(".$_GET["latitude"].") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(".$_GET["longitude"].") ) + sin( radians(".$_GET["latitude"].") ) * sin( radians( latitude ) ) ) ) AS distance ".  // From https://developers.google.com/maps/articles/phpsqlsearch_v3
				"FROM doctors WHERE name LIKE '%{$doctor}%' ORDER BY name LIMIT ".$from.", ".$to;;
				$result = mysql_query($query);
				if (mysql_num_rows($result) != 0) {
					echo "<div class = 'wrapper'><div class = 'hide'>We couldn't find a doctor within 30 mi</div></div>";
				}
			}
		}
	}
	if (!$ignore && mysql_num_rows($result) != 0) {
		?>
		<?php
		while ($row = mysql_fetch_assoc($result)) {
			include("include/phone.php");
			echo "<li>";
			echo "<a href = 'profile.php?id=".$row["id"]."' class = 'profile-link' data-transition='slide'>";
			echo "<img src = '".$row["image"]."' class = 'profilePic'>";
			echo "<span class = 'rating'>".$row["rating"]."</span>";
			echo "<h3> ".$row["name"]." </h3>";
			echo "<p>Phone: ".$phone."<br>";
			echo "Hours: ".$row["hours"]."<br>";
			echo "</p></a></li>\n";
		}
	} else {
		echo "No results found.";
	}
?>