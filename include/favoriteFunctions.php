<?php


function assignCookie(){
			
					$date_of_expiry = time() + 1000;
					
					if($_COOKIE['user'] == null) { 
    					setCookie("name" , "user", $date_of_expiry);
    					
					}
		
}

function addDoctors(){
	

						

					
					
}

?>




