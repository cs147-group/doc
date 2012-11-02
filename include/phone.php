<?php
// Format phone numbers from ints
$phone = $row["phone"];
if(preg_match('/^(\d{3})(\d{3})(\d{4})$/', $phone, $matches)) {
	$phone = '('.$matches[1].') ' .$matches[2] . '-' . $matches[3];
}
?>