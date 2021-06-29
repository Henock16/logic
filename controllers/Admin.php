<?php

	$date = strftime("%A %d %B %Y");
	$hour = date("H");
	$min = date("i");
	$sec = date("s");
	
	include_once('partials/Admin_header.php');
	include_once('views/Admin_view.php');
	include_once('partials/Admin_footer.php');
	
?>