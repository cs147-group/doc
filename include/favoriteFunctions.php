<?php




function addDoctors(){
	

						
						include("include/config.php");
						$name = $_COOKIE["name"];
						$query = "SELECT * FROM favorites WHERE cookieName = '$name'";
						$result = mysql_query($query);
						if ($result && mysql_num_rows($result) != 0) {
							
							while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    							$curDocId = $row["DoctorID"];
    							
    							$queryTwo = "SELECT * FROM doctors WHERE id = $curDocID";
    							$resultTwo = mysql_query($queryTwo);
    							
    							$rowTwo = mysql_fetch_assoc($resultTwo);
    							echo '$rowTwo["name"]';
    							echo '<li>';
    							
    							echo '<a href = "profile.php?id='.$curDocId.'" data-transition = "slide"';
    							 echo ' <img src = '.$rowTwo["image"].' class = "profilePic">';
    							  echo '<h3> '.$rowTwo["name"].' </h3>';
    							  echo '<p> Phone: '.$rowTwo["phone"].' <br> Hours: '.$rowTwo["hours"].' </br> </p>';
    							  echo '</a>';
    							echo '</li>';
    							
    								
    							
							}
						}
					
					
}

?>




