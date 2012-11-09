<?php

include("include/config.php");


function addDoctors(){
	
						$name = $_COOKIE["name"];
						$query = "SELECT * FROM favorites WHERE cookieName = '$name'";
						$result = mysql_query($query);
						if ($result && mysql_num_rows($result) != 0) {
							
							while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    							$id = $row["DoctorID"];
    							
    							$queryTwo = "SELECT * FROM doctors WHERE id = '".$id."'";
    							
    							$resultTwo = mysql_query($queryTwo);
    							$rowTwo = mysql_fetch_array($resultTwo, MYSQL_ASSOC);
    							
    							echo '<li data-swipeurl="swiped.html?'.$id.'">';
    							 echo "<img src = '".$rowTwo["image"]."'class = 'profilePic'>";
    							echo '<a href = "profile.php?id='.$id.'" data-transition = "slide"';
    								
    							  echo '<h3> '.$rowTwo["name"].' </h3>';
    							  echo '<p> Phone: '.$rowTwo["phone"].' <br> Hours: '.$rowTwo["hours"].' </br> </p>';
    							  echo '</a>';
    							echo '</li>';
    							
    								
    							
							}
						}
					
					
}

?>




