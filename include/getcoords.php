$("#<?php echo $id ?>").submit(function() {
	if ($(".latitude").val() != "" && $(".longitude").val() != "") {
		jQuery.ajaxSetup({async:false}); // Do next get synchronously
		$.get("suggestions.php?term=" + $(".symptomSearch").val(), function (data) {
			jQuery.ajaxSetup({async:true});
			symptomsFound = !(data == "[]");
			if (!symptomsFound) {
				$(".noResultsFound").text("No results found. Please try a different symptom.");
			}
		});
		return symptomsFound;
	}
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function (position) {
			$(".latitude").val(position.coords.latitude);
			$(".longitude").val(position.coords.longitude);
			$("#<?php echo $id ?>").submit();
		}, function () {
			<?php
				if ($_SERVER['SERVER_NAME'] != "localhost") {
					$url = "http://api.ipinfodb.com/v3/ip-city/?key=16ceb4e81c46df1a31558904f1da1f79e2edabc509f4ec44bdc8c169fb71a193&format=xml&ip=".$_SERVER["REMOTE_ADDR"];
					$xml = simplexml_load_file($url);
					echo "$('.latitude').val(".$xml->latitude.");";
					echo "$('.longitude').val(".$xml->longitude.");";
				}
			?>
			$("#<?php echo $id ?>").submit();
		});
	}
	return false;
});