<?php
	include("include/config.php");
	$page = $_GET["page"];
	$from = $page * 10;
	$to = ($page + 1) * 10;

	$query = "SELECT * FROM ratings WHERE id = ".$_GET["id"]." ORDER BY date DESC LIMIT ".$from.", ".$to;
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)) {
		echo "<div class = 'comment'> Rating: ".$row["rating"]."<br>";
		echo $row["comment"]."<hr></div>";
	}
?>