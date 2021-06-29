<?php
	
	function cryptCertif($idcertif){
		
		$tab1 = array('A','d','G','j','m','p','S','v','Y','x');
		$tab2 = array('z','t','U','n','f','Q','r','c','W','e');
		$len = strlen($idcertif);
		$code = '';
		
		for($i = 0; $i < $len; $i++){
			
			$code .= $tab1[intval(substr($idcertif, $i, 1))];
		}		
		$code .= $tab2[intval(substr($idcertif, -1, 1))];
		
		return $code;
	}
?>

