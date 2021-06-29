<?php
	include_once('qrlib.php');
	
	$tempDir = '../assets/qrcode/temp/' ;
	
	$instant = time();
	
	$codeContents = $_SESSION['ID_UTIL'].'.'.$_GET['egasilocedetsil'].'.'.$instant;
	
	$fileName = time().'.png';

	$pngAbsoluteFilePath = $tempDir.$fileName;
	
	QRcode::png($codeContents, $pngAbsoluteFilePath);
?>