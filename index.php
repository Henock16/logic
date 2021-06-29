<?php

	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');

	session_start();
    
    date_default_timezone_set('UTC');
	setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');

	if(isset($_SESSION['CONNECT']) && !empty($_SESSION['CONNECT'])){
		
		if($_SESSION['CONNECT'] == 1){
			
			if($_SESSION['TYPE_COMPTE'] == 0){
				
				include_once('controllers/Admin.php');
			}
			elseif($_SESSION['TYPE_COMPTE'] == 1){
				
				include_once('controllers/Matching.php');
			}
			elseif($_SESSION['TYPE_COMPTE'] == 2){
				
				include_once('controllers/Control.php');
			}
			elseif($_SESSION['TYPE_COMPTE'] == 3){
				
				include_once('controllers/Reception.php');
			}
			elseif($_SESSION['TYPE_COMPTE'] == 4){
				
				include_once('controllers/Extraire.php');
			}
			
			
			unset($_SESSION['CONNECT']);
		}
		else{
			
			$_SESSION = array();
			include_once('controllers/Authentication.php');
		}
	}		
	else{
		
		$_SESSION = array();
		include_once('controllers/Authentication.php');
	}
	
?>