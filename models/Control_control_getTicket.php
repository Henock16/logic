<?php
	include('../config/Connexion.php');

	$numtckt = $_POST['numtckt'];
	$i = 0 ;
    
	$query = $bdd -> prepare("SELECT NUM_CONTENEUR, NUM_CAMION, SITE, PROVENANCE, MARQUE, NB_EMB, POIDS_PRE_PESEE, POIDS_DEU_PESEE,TARE_HAB, TARE_CONT, TARE_EMB, POIDS_NET, INSPECTEUR, ID_CERTIF, TYPE_EMB FROM ticket WHERE ID_TICKET=:tckt");
	$query -> bindParam(':tckt', $numtckt, PDO::PARAM_INT);
	$query -> execute();
	
	while($data = $query -> fetch()){
		
		$tab[$i] = $data['NUM_CONTENEUR'];
		$i++;
		$tab[$i] = $data['NUM_CAMION'];
		$i++;

		$query1 = $bdd -> prepare("SELECT LIBELLE FROM site WHERE ID_SITE=:site");
		$query1 -> bindParam(':site', $data['SITE'], PDO::PARAM_INT);
		$query1 -> execute();
		$data1 = $query1->fetch();

		$tab[$i] = $data1['LIBELLE'];
		$i++;

		$query1 -> closeCursor();

		if($data['PROVENANCE'] == 0){			
			$tab[$i] = 0 ;
		}
		else{
			$tab[$i] = $data['PROVENANCE'];
		}
		$i++;

		if($data['MARQUE'] == 0){		
			$tab[$i] = 0 ;
		}
		else{			
			$tab[$i] = $data['MARQUE'];
		}
		$i++;

		$tab[$i] = $data['NB_EMB'];
		$i++;
		$tab[$i] = $data['POIDS_PRE_PESEE'];
		$i++;
		$tab[$i] = $data['POIDS_DEU_PESEE'];
		$i++;
		$tab[$i] = $data['TARE_HAB'];
		$i++;
		$tab[$i] = $data['TARE_CONT'];
		$i++;
		$tab[$i] = $data['TARE_EMB'];
		$i++;
		$tab[$i] = $data['POIDS_NET'];
		$i++;

		if($data['INSPECTEUR'] == 0){		
			$tab[$i] = 0 ;
		}
		else{			
			$tab[$i] = $data['INSPECTEUR'];
		}
		$i++;

		$query2 = $bdd -> query("SELECT ID_PROV,LIBELLE FROM site_provenance WHERE STATUT=0 ORDER BY LIBELLE");
		$query2 -> execute();
		$rows2 = $query2 -> rowCount();

		$tab[$i] = $rows2;
		$i++;

		while($data2 = $query2 -> fetch()){

			$tab[$i] = $data2['ID_PROV'];
			$i++;
			$tab[$i] = $data2['LIBELLE'];
			$i++;
		}
        $query2->closeCursor();
		
		$query5 = $bdd -> prepare("SELECT ID_TYPPROD,ID_PROD FROM certificat WHERE ID_CERTIF=:ct");
		$query5 -> bindParam(':ct', $data['ID_CERTIF'], PDO::PARAM_INT);
		$query5 -> execute();
		$data5 = $query5 -> fetch();
		
        $query3 = $bdd -> prepare("SELECT ID_MARQ,LIBELLE FROM marque WHERE ID_TYPPROD =:typprod ORDER BY LIBELLE");
		$query3 -> bindParam(':typprod', $data5['ID_TYPPROD'], PDO::PARAM_INT);
		$query3 -> execute();
		$rows3 = $query3 -> rowCount();

		$tab[$i] = $rows3;
		$i++;
		
		while($data3 = $query3 -> fetch()){

			$tab[$i] = $data3['ID_MARQ'];
			$i++;
			$tab[$i] = $data3['LIBELLE'];
			$i++;
		}
        $query3 -> closeCursor();
		$query5 -> closeCursor();
		
        $query4 = $bdd -> query("SELECT ID_INSP,NOM,PRENOM FROM inspecteur WHERE STATUT = 0 ORDER BY NOM");
		$query4 -> execute();
		$rows4 = $query4 -> rowCount();

		$tab[$i] = $rows4;
		$i++;
		
		while($data4 = $query4 -> fetch()){

			$tab[$i] = $data4['ID_INSP'];
			$i++;
			$tab[$i] = $data4['NOM'].' '.$data4['PRENOM'];
			$i++;
		}
        $query4 -> closeCursor();

		if($data['TYPE_EMB'] == 0){	  

			if($data5['ID_PROD']== 1){

				$tab[$i] = 3 ;
			}
			else{

				$tab[$i] = 2 ;
			}	
			
		}
		else if($data['TYPE_EMB'] != 0) {			
			$tab[$i] = $data['TYPE_EMB'];
		}
		$i++;

		$query6 = $bdd -> prepare("SELECT IDENTIFIANT,VALEUR FROM config_tare WHERE STATUT = 0 AND PRODUIT =:prod ORDER BY VALEUR");
		$query6 -> bindParam(':prod', $data5['ID_PROD'], PDO::PARAM_INT);
		$query6 -> execute();
		$rows6 = $query6 -> rowCount();

		$tab[$i] = $rows6;
		$i++;
		
		while($data6 = $query6 -> fetch()){

			$tab[$i] = $data6['IDENTIFIANT'];
			$i++;
			$tab[$i] = $data6['VALEUR'];
			$i++;
		}
        $query6 -> closeCursor();
	}	
	$bdd = null;
	
    /* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>