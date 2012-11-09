<?php
	include("include/config.php");
	$query = "SELECT symptoms FROM symptoms WHERE symptoms LIKE '".$_GET["term"]."%' ORDER BY symptoms LIMIT 0, 5";
	$result = mysql_query($query);
	echo "[";
	$i = 0;
	$num = mysql_num_rows($result);
	while ($row = mysql_fetch_assoc($result)) {
		echo '"'.$row["symptoms"].'"';
		if ($i != ($num - 1)) echo ",";
		$i++;
	}
	echo "]";
?>