<?php
	class PDF extends FPDF{
		
		function Footer(){
			// Go to 1.5 cm from bottom
			$this->SetY(-10);
			// Select Arial italic 8
			//$this->SetFont('Arial','I',8);
			// Print centered page number
			//$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
		}

		function Add_Entete($num, $bdd){
			
			if(empty($num) || ($num == '') || ($num == null) ){
			
				$title = "CERTIFICAT DE PESAGE PROVISOIRE";
				$this -> SetFont('Arial','B',15);
				$this -> SetTextColor(127);
				$this -> Cell(190,10,$title,'',0,'C');
			}
			else{
				
				include_once('../functions/CryptCertif_function.php');
				include_once('../assets/qrcode/qrcode_certif.php');
				
				$this -> Image($tempDir.'/'.$fileName,8,257,20,20,'png');
				
				$this -> Ln(28);
				$this -> SetFont('Arial','B',12);
				$this -> SetTextColor(40,40,40);
				$this -> SetFillColor(224,224,224);
				$this -> SetDrawColor(224,224,224);
				$this -> Cell(60,5,'','',0,'C',false);
				$this -> Cell(60,5,$num,'LTBR',0,'C',true);
				$this -> Cell(60,5,'','',0,'C',false);
			}
			// Certification
			$certif = utf8_decode("Conformement au décret 2001-695 du 31 Octobre 2001 autorisant la Chambre de Commerce et d'Industrie de Côte d'Ivoire à effectuer le pesage des marchandises générales au cordon douanier, à l'arrêté interministériel N° 367 du 27 Octobre 2003 modifiant et complétant l'arrêté interministériel N° 32 du 17 février 2003 fixant les modalités d'application du décret N° 695 du 31 octobre 2001, autorisant le pesage des marchandises générales au cordon douanier par la Chambre de Commerce et d'Industrie, nous Chambre de Commerce et d'Industrie(CCI-CI), attestons avoir procédé au contrôle des poids sur les ponts bascules accrédités.");

			$this -> Ln(18);
			$this -> SetFont('Times','IB',11);
			$this -> SetTextColor(40,40,40);
			$this -> SetFillColor(255,255,255);
			$this -> SetDrawColor(255,255,255);
			$this -> MultiCell(190,4,$certif,1,'J');
		}

		function Add_Info_Export($infoexp){
			
			//CAJOU
			if(count($infoexp) == 12){
				
				$champ = array('Récolte','Exportateur','Campagne','Client','Produit','Destination','Date','Navire','Type Conteneur','Packing list N°','Transitaire','OT N°');
			}
			//COTON
			elseif(count($infoexp) == 14){
				
				$champ = array('Récolte','Exportateur','Campagne','N° Inst. Fournisseur','Produit','Client','Rapport empotage','N° Inst. Client','Type Conteneur','Destination','Transitaire','Navire','Egréneur','N° Dossier');
			}
			
			$this -> SetDrawColor(0,0,0);
			$this -> SetLineWidth(0.1);
			$this -> SetFillColor(255,255,255);
			$this -> Ln(5);

			for($i = 0; $i<round(count($infoexp)/2); $i++){
				
				$this -> SetFont('Arial','IB',8);
				$this -> Cell(((count($infoexp) == 12)?24:29),6,utf8_decode($champ[2*$i]),'LRTB',0,'L',true);
				$this -> SetFont('Arial','I',8);
				$this -> Cell(65,6,utf8_decode($infoexp[2*$i]),'LRTB',0,'L',true);
				$this -> Cell(2,6,'','L',0,'',true);
				$this -> SetFont('Arial','IB',8);
				$this -> Cell(((count($infoexp) == 12)?22:29),6,utf8_decode($champ[2*$i+1]),'LRTB',0,'L',true);
				$this -> SetFont('Arial','I',8);
				$this -> Cell(((count($infoexp) == 12)?77:65),6,utf8_decode($infoexp[2*$i+1]),'LRTB',0,'L',true);
				$this -> Cell(10,6,'',0,0,'',true);
				$this -> Ln();
			}
			$this -> Ln(5);
		}

		function Tableau($type,$data,$contr,$Peseurs,$num,$Exp){

			// Titres des colonnes
			$header = array();
			//CAJOU
			if($type == 1){
				
				$header[] = array("","","","","","","","","Cart.","Nbre","Poids","Poids","Tare","Tare","Poids");
				$header[] = array("Nb","Provenance","Pont bascule","Date","N°Camion","N° Ticket","N° Conteneur","N° Plomb","Ond.","de","Entrée","Sortie","Cont.","Sacs","Net");
				$header[] = array("","","","","","","","","","Sacs","(Kg)","(Kg)","","","(Kg)");
			}
			//COTON
			elseif($type == 2){
				
				$header[] = array("","","","","","","","","","Nbre","Poids","Poids","Tare","Tare","Poids");
				$header[] = array("Nb","Provenance","Pont bascule","Date","N°Camion","N° Ticket","N° Conteneur","N° Plomb","Marque","de","Entrée","Sortie","Cont.","Balles","Net");
				$header[] = array("","","","","","","","","","Balles","(Kg)","(Kg)","","","(Kg)");
			}

			//Largeurs des colones
			//CAJOU
			if($type == 1){
				
				$w = array(5,21,21,12,12,16,17,16,8,8,12,12,10,8,12);
			}
			//COTON
			else  if($type == 2){
				
				$w = array(5,19,19,12,12,16,17,16,12,8,12,12,10,8,12);
			}

			//Hauteur des lignes
			$h = 5;
			//Totaux
			$totaux = array(0,0,0,0,0,0,0);
			// Données
			$i = 0;
			$page = 0;
			
			foreach($data as $row){
				
				//Nouvelle page
				if($i == 0){
					
					$page++;
					
					if($page>1){
						
						$this -> AddPage();
					}
					$this -> SetAutoPageBreak(true,2);

					// Couleurs, épaisseur du trait et police grasse
					$this -> SetFont('Arial','B',7);
					$this -> SetTextColor(0);
					$this -> SetDrawColor(0,0,0);
					$this -> SetLineWidth(0.1);
					$this -> SetFillColor(210);
					
					// En-tête
					for($j = 0; $j<3; $j++){
						
						for($k = 0; $k<count($w); $k++){
							
							$this -> Cell($w[$k],3,utf8_decode($header[$j][$k]),'LR'.(($j==0)?'T':(($j==2)?'B':'')),(($k==count($w)-1)?1:0),'C',true);
						}				
					}				

					// Restauration des couleurs et de la police
					$this -> SetTextColor(0);
					$this -> SetFont('');
				}				
				
				$this -> SetFont('Arial','',6);
				//Une ligne du tableau
				$i++;
				$this -> SetFillColor(255,255,255);
				$this -> Cell($w[0],$h,number_format($row[0],0,',',' '),'BL',0,'C',true);
				$this -> Cell($w[1],$h,utf8_decode($row[1]),'BL',0,'L',true);
				$this -> Cell($w[2],$h,utf8_decode($row[2]),'BL',0,'L',true);
				$this -> Cell($w[3],$h,utf8_decode($row[3]),'BL',0,'C',true);
				$this -> Cell($w[4],$h,utf8_decode($row[4]),'BL',0,'C',true);
				
				if( strlen(utf8_decode($row[5])) > 11){
					$row[5] = substr($row[5], -11);
				}
				
				$this -> SetFillColor(210);
				$this -> Cell($w[5],$h,utf8_decode($row[5]),'BL',0,'C',true);
				$this -> Cell($w[6],$h,utf8_decode($row[6]),'BL',0,'C',true);
				
				if( strlen(utf8_decode($row[7])) > 10){
					$row[7] = substr($row[7], -10);
				}
				
				$this -> Cell($w[7],$h,utf8_decode($row[7]),'BL',0,'L',true);
				$this -> Cell($w[8],$h,utf8_decode($row[8]),'BL',0,($type==2)?'L':'C',true);
				$this -> Cell($w[9],$h,utf8_decode(number_format($row[9], 0, ',', ' ')),'BL',0,'C',true);
				$this -> Cell($w[10],$h,utf8_decode(number_format($row[10], 0, ',', ' ')),'BL',0,'C',true);
				$this -> Cell($w[11],$h,utf8_decode(number_format($row[11], 0, ',', ' ')),'BL',0,'C',true);
				$this -> Cell($w[12],$h,utf8_decode(number_format($row[12], 0, ',', ' ')),'BL',0,'C',true);
				$this -> Cell($w[13],$h,utf8_decode(number_format($row[13], 0, ',', ' ')),'BL',0,'C',true);
				$this -> Cell($w[14],$h,utf8_decode(number_format($row[14], 0, ',', ' ')),'BLR',0,'C',true);
				$this -> Ln();

				//remplissage du tableau
				for($j = (($type==2)?1:0); $j < count($totaux); $j++){
					
					$totaux[$j]+=$row[$j+8];
				}
				//si le bas de la page est atteinte par le tableau, nouvelle page
				if((($page==1) && ($i==20)) || (($page>1) && ($i==40))){
					
					$i = 0;
				}
			}

			//Les totaux
			$this -> SetFont('Arial','B',7);
			$this -> SetFillColor(210);
			$this -> Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+(($type==2)?$w[8]:0),$h,'TOTAL','BL',0,'C',true);
			
			//CAJOU
			if($type == 1){
				
				$this -> Cell($w[8],$h,utf8_decode(number_format($totaux[0],0,',',' ')),'BL',0,'C',true);
			}
			
			$this -> Cell($w[9],$h,utf8_decode(number_format($totaux[1],0,',',' ')),'BL',0,'C',true);
			$this -> Cell($w[10],$h,utf8_decode(number_format($totaux[2],0,',',' ')),'BL',0,'C',true);
			$this -> Cell($w[11],$h,utf8_decode(number_format($totaux[3],0,',',' ')),'BL',0,'C',true);
			$this -> Cell($w[12],$h,utf8_decode(number_format($totaux[4],0,',',' ')),'BL',0,'C',true);
			$this -> Cell($w[13],$h,utf8_decode(number_format($totaux[5],0,',',' ')),'BL',0,'C',true);
			$this -> Cell($w[14],$h,utf8_decode(number_format($totaux[6],0,',',' ')),'BLR',0,'C',true);
			$this -> Ln();

			//Bas du tableau
			$this -> SetFillColor(255,255,255);
			$this -> SetFont('Arial','IB',9);
			$this -> Cell(60,5,utf8_decode("CCI-CI ".$contr),'',0,'LR',true);
			$this -> SetFont('Arial','I',8);
			$this -> Cell(130,5,utf8_decode("Peseurs(s) : ".$Peseurs),'',0,'LR',true);
			$this -> Ln();
			
			if(!empty($num) && ($num != '') && ($num != null) ){
				
				$this -> Cell(120,5,utf8_decode("Certificat de pesage N° :  ".$num),'',0,'LR',true);
			}
			
			$this -> Cell(70,5,utf8_decode("Exportateur : ".$Exp),'',0,'L',true);
			$this -> Ln();
			$this -> Cell(190,5,utf8_decode("Le présent certificat, conforme aux chiffres accusés par les pesées est délivré pour servir et valoir ce que de droit."),'',0,'L',true);
			$this -> Ln();
			$this -> Cell(165,5,utf8_decode(""),'',0,'L',true);
			$this -> SetFont('Times','IB',11);
			$this -> Cell(25,5,utf8_decode(date("d/m/Y")),'',0,'C',false);
			$this -> Ln();
		}
	}

	//Mettre la date au bon format 
	function dateFr($date){
		
		return strftime('%d/%m/%Y',strtotime($date));
	}

	//Libellé du site de provenance
	function GetProv($bdd,$id){
		
		$lib = "";
		
		if(is_numeric($id)){
			
			$rep = $bdd -> query("SELECT LIBELLE FROM site_provenance WHERE ID_PROV=".$id);
			
			while($don = $rep -> fetch()){
				
				$lib = $don['LIBELLE'];
			}
			$rep -> closeCursor();
		}
		return $lib;
	}

	//Libellé du pont bascule ou site d'empotage
	function GetSite($bdd,$id){
		
		$lib = "";
		
		if(is_numeric($id)){
			
			$rep = $bdd -> query("SELECT LIBELLE FROM site WHERE ID_SITE=".$id);
			
			while ($don = $rep -> fetch()){
				
				$lib = $don['LIBELLE'];
			}
			$rep -> closeCursor();
		}
		return $lib;
	}

	//Libellé de la marque
	function GetMarq($bdd,$id){
		
		$lib = "";
		
		if(is_numeric($id)){
			
			$rep = $bdd -> query("SELECT LIBELLE FROM marque WHERE ID_MARQ=".$id);
			
			while ($don = $rep -> fetch()){
				
				$lib = $don['LIBELLE'];
			}
			$rep -> closeCursor();
		}
		return $lib;
	}

	//Noms de l'inspecteur
	function GetPes($bdd,$id){
		
		$lib = "";
		
		if(is_numeric($id)){
			
			$rep = $bdd -> query("SELECT NOM,PRENOM FROM inspecteur WHERE ID_INSP=".$id);
			
			while ($don = $rep -> fetch()){
				
				$lib = $don['NOM']." ".$don['PRENOM'];
			}
			$rep -> closeCursor();
		}
		return $lib;
	}

	//Nom du controleur
	function GetContr($bdd,$id){
		
		$lib = "";
		
		if(is_numeric($id)){
			
			$rep = $bdd -> query("SELECT NOM,PRENOM FROM utilisateur WHERE ID_UTIL=".$id);
			
			while ($don = $rep -> fetch()){
				
				$lib = $don['NOM']." ".$don['PRENOM'];
			}
			$rep -> closeCursor();
		}
		return $lib;
	}

	//Libellé de la recolte
	function GetRec($bdd,$id){
		
		$lib = "";
		
		if(is_numeric($id)){
			
			$query = $bdd -> query("SELECT LIBELLE FROM recolte WHERE ID_REC=".$id);
			
			while($don = $query -> fetch()){
				
				$lib = $don['LIBELLE'];
			}
			$query -> closeCursor();
		}
		return utf8_decode($lib);
	}

	//Libellé de l'exportateur
	function GetExp($bdd,$id){
		
		$lib = "";
		
		if(is_numeric($id)){
			
			$rep = $bdd -> query("SELECT LIBELLE FROM exportateur WHERE ID_EXP=".$id);
			
			while ($don = $rep -> fetch()){
				
				$lib = $don['LIBELLE'];
			}
			$rep -> closeCursor();
		}
		return utf8_decode($lib);
	}

	//Libellé de la campagne
	function GetCamp($bdd,$id){
		
		$lib = "";
		
		if(is_numeric($id)){
			
			$rep = $bdd -> query("SELECT LIBELLE FROM campagne WHERE ID_CAMP=".$id);
			
			while ($don = $rep -> fetch()){
				
				$lib = $don['LIBELLE'];
			}
			$rep -> closeCursor();
		}
		return utf8_decode($lib);
	}

	//Libellé du produit
	function GetProd($bdd,$id){
		
		$lib = "";
		if(is_numeric($id)){
			
			$rep = $bdd -> query("SELECT LIBELLE FROM type_produit WHERE ID_TYPPROD=".$id);
			
			while ($don = $rep -> fetch()){
				
				$lib = $don['LIBELLE'];
			}
			$rep -> closeCursor();
		}
		return utf8_decode($lib);
	}

	//Libellé de la destination
	function GetDest($bdd,$id){
		
		$lib = "";
		
		if(is_numeric($id)){
			
			$rep = $bdd -> query("SELECT PORT, PAYS FROM destination WHERE ID_DEST=".$id);
			
			while ($don = $rep -> fetch()){
				
				$lib = $don['PORT'].", ".$don['PAYS'];
			}
			$rep -> closeCursor();
		}
		return utf8_decode($lib);
	}

	//Libellé du transitaire
	function GetTrans($bdd,$id){
		
		$lib = "";
		
		if(is_numeric($id)){
			
			$rep = $bdd -> query("SELECT LIBELLE FROM transitaire WHERE ID_TRANSIT=".$id);
			
			while ($don = $rep -> fetch()){
				
				$lib = $don['LIBELLE'];
			}
			$rep -> closeCursor();
		}
		return utf8_decode($lib);
	}

	//Libellé de l'égréneur
	function GetEgre($bdd,$id){
		
		$lib = "";
		
		if(is_numeric($id)){
			
			$rep = $bdd -> query("SELECT LIBELLE FROM egreneur WHERE ID_EGRE=".$id);
			
			while ($don = $rep -> fetch()){
				
				$lib = $don['LIBELLE'];
			}
			$rep -> closeCursor();
		}
		return utf8_decode($lib);
	}
?>