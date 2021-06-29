<?php

	$date = strftime("%A %d %B %Y");
	$hour = date("H");
	$min = date("i");
	$sec = date("s");
	
	include_once('partials/Authentication_header.php');
	include_once('views/Authentication_view.php');
	include_once('partials/Authentication_footer.php');
	
?>