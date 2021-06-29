<?php
	include_once('qrlib.php');
	
	$tempDir = '../assets/qrcode/temp/' ;
	
	$instant = time();
	$numpk = $_GET['numpk'];
	
	$query = $bdd -> prepare("SELECT ID_CERTIF FROM certificat WHERE NUM_PCKLIST =:pklist ORDER BY ID_CERTIF DESC LIMIT 1");
	$query -> bindParam(':pklist', $numpk, PDO::PARAM_STR);
	$query -> execute();
	$row = $query -> rowCount();

	if($row > 0){
		
		$data = $query -> fetch();
		$codeContents = cryptCertif($data['ID_CERTIF']);
	}
	else{
		$codeContents = '';
	}
	
	$fileName = time().'.png';

	$pngAbsoluteFilePath = $tempDir.$fileName;
	
	QRcode::png($codeContents, $pngAbsoluteFilePath);
?>