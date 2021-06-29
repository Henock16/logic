<?php
	ini_set('session.gc_maxlifetime','28800');
	session_start();
	
	if( isset($_SESSION['ID_UTIL']) && !(empty($_SESSION['ID_UTIL'])) ){
		
		if( isset($_GET['egasilocedetsil']) && !(empty($_GET['egasilocedetsil'])) ){
			
			include_once('../config/Connexion.php');
			
			require('../assets/fpdf/fpdf.php');
			include('../models/GetPackinglistInfoPDF_model.php');
			
			if($Prod == 1){
				
				include('../models/CreatePackinglistCajouPDF_model.php');
				
				$pdf = new PDF();
				$pdf -> AddPage();
				$pdf -> logo_entreprise($Logo);
				$pdf -> info_expor($List,$Camp,$Recol,$Expor,$Type,$Trans,$OT,$Doss,$Dest,$DateD,$DateF,$Destin,$Nav);
				$pdf -> info_pesee($_GET['egasilocedetsil']);
				$pdf -> signature($Nom,$Pren,$Fonc,$Tel);
				$pdf -> piedpage($NumAR);
				$pdf -> Output('I');
			}
			if($Prod == 2){	
			
				include('../models/CreatePackinglistCotonPDF_model.php');
				
				$pdf = new PDF();
				$pdf -> AddPage();
				$pdf -> logo_entreprise($Logo);
				$pdf -> info_expor($List,$Camp,$Recol,$Expor,$Egren,$Type,$Trans,$Doss,$Client,$Four,$Dest,$DateD,$DateF,$Destin,$Nav);
				$pdf -> info_pesee($_GET['egasilocedetsil']);
				$pdf -> signature($Nom,$Pren,$Fonc,$Tel);
				$pdf -> piedpage($NumAR);
				$pdf -> Output('I');
			}
		}
	}
?>