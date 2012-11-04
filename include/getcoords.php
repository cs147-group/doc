$("#<?php echo $id ?>").submit(function() {
	if ($(".latitude").val() != "" && $(".longitude").val() != "") {
		return true;
	}
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function (position) {
			$(".latitude").val(position.coords.latitude);
			$(".longitude").val(position.coords.longitude);
			$("#<?php echo $id ?>").submit();
		});
	}
	return false;
});