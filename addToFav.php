<?php
	include("include/config.php");
	$query = "SELECT * from favorites WHERE userid = '".$_COOKIE["userid"]."' AND doctorid = ".$_GET["id"];
	$result = mysql_query($query);
	if (mysql_num_rows($result) == 0) {
		$query = "INSERT INTO favorites (userid, doctorid) VALUES ('".$_COOKIE["userid"]."', '".$_GET["id"]."')";
		mysql_query($query);
	}
?>