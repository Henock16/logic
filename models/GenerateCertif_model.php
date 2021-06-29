<?php

	include_once('../config/Connexion.php');
	require('../assets/fpdf/fpdf.php');
	include_once('CreatePDF_model.php');
	
	if(isset($_GET['numpk']) && !empty($_GET['numpk'])){

		if(isset($_GET['cont']) && !empty($_GET['cont'])){			
			
			$i = 0;
			
			$query = $bdd -> prepare("SELECT * FROM certificat WHERE NUM_PCKLIST=:pcklist AND DISABLED = 0");
			$query -> bindParam(':pcklist', $_GET['numpk'], PDO::PARAM_STR);
			$query -> execute();
			
			while($data = $query -> fetch()){
				
				$i++;
				$num = $data['NUM_CERTIF'];
				$type = $data['ID_PROD'];

				//Informations des pesées conteneur
				$weightdata = array();
				$Peseurs = '';
				
				$query1 = $bdd -> prepare("SELECT * FROM ticket WHERE id_CERTIF=:certif");
				$query1 -> bindParam(':certif', $data['ID_CERTIF'], PDO::PARAM_INT);
				$query1 -> execute();
				
				$tc20 = 0;
				$tc40 = 0;
				$j = 0;
				$list[0] = 0;
				$p = 0;
				
				while($data1 = $query1 -> fetch()){
					
					$j++;
					
					$Prov = GetProv($bdd,$data1['PROVENANCE']);
					$Site = GetSite($bdd,$data1['SITE']);
					$Marq = GetMarq($bdd,$data1['MARQUE']);
					
					$bool = true ;
					
					for($k = 0; $k < count($list); $k++){
						
						if($list[$k] ==  $data1['INSPECTEUR']){
							
							$bool = false ;
						}						
					}
					
					if($bool){
						
						$list[$p] = $data1['INSPECTEUR'];
						$p++;
						$Pes = GetPes($bdd,$data1['INSPECTEUR']);
					}
					else{
						
						$Pes = '';
					}
					
					//CAJOU
					if($type == 1){
						
						$weightdata[] = array($j,$Prov,$Site,dateFr(substr($data1['DATE_PESEE'],0,10)),$data1['NUM_CAMION'],$data1['NUM_TICKET'],$data1['NUM_CONTENEUR'],$data1['NUM_PLOMB'],$data1['TARE_HAB'],$data1['NB_EMB'],$data1['POIDS_DEU_PESEE'],$data1['POIDS_PRE_PESEE'],$data1['TARE_CONT'],$data1['NB_EMB'],$data1['POIDS_NET']);
					}
					//COTON
					else if($type == 2){
						
						$weightdata[] = array($j,$Prov,$Site,dateFr(substr($data1['DATE_PESEE'],0,10)),$data1['NUM_CAMION'],$data1['NUM_TICKET'],$data1['NUM_CONTENEUR'],$data1['NUM_PLOMB'],$Marq,$data1['NB_EMB'],$data1['POIDS_DEU_PESEE'],$data1['POIDS_PRE_PESEE'],$data1['TARE_CONT'],$data1['TARE_EMB'],$data1['POIDS_NET']);
					}			

					//Type de conteneur
					$tc20 += (($data1['TARE_CONT'] < 3000) ? 1 : 0);
					$tc40 += (($data1['TARE_CONT'] > 3000) ? 1 : 0);

					//Lites des péseurs
					$Peseurs .= ($Pes?($Peseurs ? ', ' : '').$Pes:'');
				}
				$query1 -> closeCursor();

				//Informations d'exportation
				$Rec = GetRec($bdd,$data['ID_REC']);
				$Exp = GetExp($bdd,$data['ID_EXP']);
				$Camp = GetCamp($bdd,$data['ID_CAMP']);
				$Prod = GetProd($bdd,$data['ID_TYPPROD']);
				$TypCont = ($tc20?$tc20."x20'":"").(($tc20&&$tc40)?" ":"").($tc40?$tc40."x40'":"");
				$Dest = GetDest($bdd,$data['ID_DEST']);
				$Trans = GetTrans($bdd,$data['ID_TRANSIT']);
				
				//CAJOU
				if($type == 1){
					
					$infoexp = array($Rec,$Exp,$Camp,$data['CLIENT'],$Prod,$Dest,date('d/m/Y', strtotime($data['DATE_PACKLIST'])),$data['NAVIRE'],$TypCont,$data['NUM_PCKLIST'],$Trans,$data['NUM_OT']);
				}
				//COTON
				else if($type == 2){
					
					$infoexp = array($Rec,$Exp,$Camp,$data['NUM_INST_FOUR'],$Prod,$data['CLIENT'],$data['NUM_RAP_EMP'],$data['NUM_INST_CLI'],$TypCont,$Dest,$Trans,$data['NAVIRE'],GetEgre($bdd,$data['ID_EGRE']),$data['NUM_DOSS']);
				}	
			}
			$query -> closeCursor();
			
			if($i){

				$fichier = "CERTIFICAT_PROVISOIRE_".$_GET['numpk'].".pdf";
				
				header("Content-type:application/pdf");
				$pdf = new PDF();
				$pdf -> AddPage();
				$pdf -> Add_Entete($num, $bdd);
				$pdf -> Add_Info_Export($infoexp);
				$pdf -> Tableau($type,$weightdata,GetContr($bdd,$_GET['cont']),$Peseurs,$num,$Exp);
				$pdf -> Footer();
				
				if(!empty($num)){
				
					$query2 = $bdd -> prepare("SELECT NB_EDIT FROM certificat WHERE NUM_PCKLIST=:pcklist");
					$query2 -> bindParam(':pcklist', $_GET['numpk'], PDO::PARAM_STR);
					$query2 -> execute();
					$data2 = $query2 -> fetch();
					
					$edit = $data2['NB_EDIT'] + 1;
					
					$query2 -> closeCursor();
					
					$query3 = $bdd -> prepare("UPDATE certificat SET NB_EDIT = :edit WHERE NUM_PCKLIST=:pcklist");
					$query3 -> bindParam(':edit', $edit, PDO::PARAM_INT);
					$query3 -> bindParam(':pcklist', $_GET['numpk'], PDO::PARAM_STR);
					$query3 -> execute();
					$query3 -> closeCursor();
				}				
				$bdd = null;
				
				$pdf -> Output('I');
			}
			else{
				//Certificat pas trouvé
				$tab[0] = 0;
			}
		}
		else{
			//Veuillez renseigner l'identifiant du controleur
			$tab[0] = 1;
		}
	}
	else{
		//Veuillez renseigner l'identifiant du certificat
		$tab[0] = 2;
	}
?>
