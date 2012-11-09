<?php


function getIP(){
	
	return $_SERVER['REMOTE_ADDR'];
	
}

function assignCookie($ip){
			
					$date_of_expiry = time() + 1000;
					if($_cookie("user") == null) { 
    					setcookie($ip , "user", $date_of_expiry);
    					
					}
		
}

function addDoctors(){
	

						
						include("include/config.php");
						$ip = getIP();
						$query = "SELECT * FROM favorites WHERE ipAddress = '".$ip."'";
						$result = mysql_query($query);
						if ($result && mysql_num_rows($result) != 0) {
							
							while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    							$curDocId = $row["DoctorID"];
    							$queryTwo = "SELECT * FROM doctors WHERE id = '".$curDocID."'";
    							$resultTwo = mysql_query($query);
    							$rowTwo = mysql_fetch_assoc($resultTwo);
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




