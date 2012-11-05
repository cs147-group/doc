$("#<?php echo $id ?>").submit(function() {
	if ($(".latitude").val() != "" && $(".longitude").val() != "") {
		return true;
	}
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function (position) {
			$(".latitude").val(position.coords.latitude);
			$(".longitude").val(position.coords.longitude);
			$("#<?php echo $id ?>").submit();
		}, function () {
			<?php
				$url = "http://api.ipinfodb.com/v3/ip-city/?key=16ceb4e81c46df1a31558904f1da1f79e2edabc509f4ec44bdc8c169fb71a193&format=xml&ip=".$_SERVER["REMOTE_ADDR"];
				$xml = simplexml_load_file($url);
				echo "$('.latitude').val(".$xml->latitude.");";
				echo "$('.longitude').val(".$xml->longitude.");";
			?>
			$("#<?php echo $id ?>").submit();
		});
	}
	return false;
});