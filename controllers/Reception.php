<?php

	$date = strftime("%A %d %B %Y");
	$hour = date("H");
	$min = date("i");
	$sec = date("s");
	
	include_once('partials/Admin_header.php');
	include_once('views/Reception_view.php');
	include_once('partials/Reception_footer.php');
	
?>