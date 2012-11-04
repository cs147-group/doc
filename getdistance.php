<?php
	include("include/config.php");
	$query = "SELECT ( 3959 * acos( cos( radians(".$_POST["latitude"].") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(".$_POST["longitude"].") ) + sin( radians(".$_POST["latitude"].") ) * sin( radians( latitude ) ) ) ) AS distance FROM doctors WHERE id = '".$_POST["id"]."'"; // From https://developers.google.com/maps/articles/phpsqlsearch_v3
	$result = mysql_query($query);
	if ($result) {
		$row = mysql_fetch_assoc($result);
		echo round($row["distance"], 1)." mi";
	}
?>