<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();
	
	$tab[0] = $_SESSION['ROLE'];
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>