<?php
	include("include/config.php");
	$query = "SELECT * FROM favorites WHERE userid = '".$_COOKIE["userid"]."' AND doctorid = ".$_GET["id"];
	$result = mysql_query($query);
	if (mysql_num_rows($result) != 0) {
		$query = "DELETE FROM favorites WHERE userid = '".$_COOKIE["userid"]."' AND doctorid = '".$_GET["id"]."'";
		mysql_query($query);
	}
?>