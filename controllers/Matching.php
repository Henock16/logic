<?php

	$date = strftime("%A %d %B %Y");
	$hour = date("H");
	$min = date("i");
	$sec = date("s");
	
	include_once('partials/User_header.php');
	include_once('views/Matching_view.php');
	include_once('partials/Matching_footer.php');
	
?>