<?php
	include("include/config.php");
	$id = $_POST["id"];
	$date = date('Y-m-d H:i:s', time()); // From http://www.richardlord.net/blog/dates-in-php-and-mysql
	$rating = $_POST["rating"];
	$comment = $_POST["comment"];
	$query = "INSERT INTO ratings (id, date, rating, comment) VALUES ('$id', '$date', '$rating', '$comment')";
	$result = mysql_query($query);
	if ($result) {
		$query = "SELECT * FROM doctors WHERE id = ".$id;
		$result = mysql_query($query);
		if (mysql_num_rows($result) != 0) {
			$row = mysql_fetch_assoc($result);
			$rating = ($row["rating"] * $row["nratings"] + $rating) / ($row["nratings"] + 1);
			$query = "UPDATE doctors SET nratings = ".($row["nratings"] + 1).", rating = ".$rating." WHERE id = ".$id;
			mysql_query($query);
		}
	}
?>