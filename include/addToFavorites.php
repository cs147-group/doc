



function addToFavorites($id){
	<?php
	include("include/favoriteFunctions.php");
	include("include/config.php");
	assignCookie();
	echo ($_cookie["user"]);
	?>
	INSERT INTO FAVORITES VALUES($_cookie("user"), $id);
	
}

