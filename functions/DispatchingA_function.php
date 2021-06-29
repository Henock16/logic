<?php
	include_once('Journalisation_function.php');

	function Dispatching($id_cible,$step,$bdd){

		$result[0] = 0;
		$util_min = 0;
		$i = 0;
		
		$dat = date('Y-m-d');
		$dat1 = date('Y-m-d 00:00:00');
		$dat2 = date('Y-m-d 23:59:59');

		if( $step == 1){

			$query = $bdd ->prepare("SELECT ID_VILLE FROM certificat WHERE ID_CERTIF =:certif");
			$query -> bindParam(':certif', $id_cible, PDO::PARAM_STR);
			$query -> execute();
			$data = $query -> fetch();
			$ville = $data['ID_VILLE'];
			$query -> closeCursor();

			$query1 = $bdd->prepare("SELECT ID_UTIL FROM utilisateur WHERE TYPE_COMPTE=1 AND STAT_COMPTE = 0 AND JOUR=:jou AND PREM_CONNEXION = 1 AND ID_VILLE=:vil ORDER BY COMPTE");
			$query1 -> bindParam(':jou', $dat, PDO::PARAM_STR);
			$query1 -> bindParam(':vil', $ville, PDO::PARAM_INT);
			$query1 -> execute();
			$data1 = $query1 -> fetch();
			$util =$data['ID_UTIL'];
			$query1 -> execute();
			$query1 -> closeCursor();
			
			$query2 = $bdd -> prepare("UPDATE certificat SET ID_USER_PREC=0,ID_USER_COUR=:utilc,STADE=1,STATUT=1,CHANG_STAT=0 WHERE ID_CERTIF =:certif");
			$query2 -> bindParam(':util', $util, PDO::PARAM_INT);
			$query2 -> bindParam(':certif', $id_cible, PDO::PARAM_INT);
			$query2 -> execute();
			$query2 -> closeCursor();
			

			$query3 = $bdd -> prepare("UPDATE bordereau SET STATUT = 1 WHERE ID_BORD=:bord");
			$query3 -> bindParam(':bord', $id_bord, PDO::PARAM_INT);
			$query3 -> execute();
			$query3 -> closeCursor();

			$result[1] = 'Administrateur';
		}

		if(($step == 3) || ($step == 4) || ($step == 5) || ($step == 6)){

			$query4 = $bdd -> prepare("SELECT ID_CERTIF FROM certif_bord WHERE ID_BORD=:bord");
			$query4 -> bindParam(':bord', $id_bord, PDO::PARAM_INT);
			$query4 -> execute();

			$j = 0;
			
			while($data4 = $query4 -> fetch()){

				$tab_certif[$j] = $data4['ID_CERTIF'];
				$j++;
			}
			$query4 -> closeCursor(); 

			$tab_usernonconf[0] = 0;
			$m = 0;
			$fin = true;

			$query5 = $bdd->prepare("SELECT ID_UTIL FROM utilisateur WHERE TYPE_COMPTE=2 AND STAT_COMPTE = 0 AND JOUR=:jou AND ID_VILLE=:vil AND ID_UTIL<>:util ORDER BY COMPTE");
			$query5 -> bindParam(':jou', $dat, PDO::PARAM_STR);
			$query5 -> bindParam(':vil', $ville, PDO::PARAM_INT);
			$query5 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
			$query5 -> execute();
			$rows5 = $query5 -> rowCount();
			
			$query6 = $bdd -> prepare("UPDATE bordereau SET STATUT = 1 WHERE ID_BORD=:bord ");
			$query6 -> bindParam(':bord', $id_bord, PDO::PARAM_INT);
			$query6 -> execute();
			$query6 -> closeCursor();
			
			if($rows5 >= 1){
			
				while($data5 = $query5 -> fetch()){				

					$tab_usernonconf[$m+1] = 0;
					$temp = 0;

					for($k = 0; $k < $j; $k++){

						$conf = true;

						$query7 = $bdd -> prepare("SELECT ID_CB FROM bordereau,certif_bord WHERE bordereau.ID_BORD=certif_bord.ID_BORD AND ID_USER=:util AND STADE<>1 AND ID_CERTIF=:certif");
						$query7 -> bindParam(':util', $data5['ID_UTIL'], PDO::PARAM_INT);
						$query7 -> bindParam(':certif', $tab_certif[$k], PDO::PARAM_INT);
						$query7 -> execute();
						$rows7 = $query7 -> rowCount() ;					

						if($rows7 >= 1){

							$tab_usernonconf[$m] = $data5['ID_UTIL'];
							$conf = false;
							$temp += 1 ;
							$fin = false;
						}
						$tab_usernonconf[$m+1] =$temp;						
					}			

					if($conf){
						
						$fin = true ;
						$util_min = $data5['ID_UTIL'];
						$query5 -> closeCursor();
					}
					$m += 2 ;
				}
				$query5->closeCursor();				

				if($fin == false){

					if($m == 2){

						$util_min = $tab_usernonconf[0];
					}
					else{

						$compte = $tab_usernonconf[1];

						for($o = 3; $o < $m; $o++){

							if($compte >= $tab_usernonconf[$o]){

								$compte = $tab_usernonconf[$o];
								$util_min = $tab_usernonconf[$o-1];
							}
						}
						$o++;
					}
				}

				$count = 0;
				
				for($p = 0; $p < $j; $p++){

					$query8 = $bdd -> prepare("UPDATE certificat SET STADE=:st, ID_USER_PREC=:util,ID_USER_COUR=:utilc WHERE ID_CERTIF =:certif");
					$query8 -> bindParam(':st', $step, PDO::PARAM_INT);
					$query8 -> bindParam(':util', $util, PDO::PARAM_INT);
					$query8 -> bindParam(':utilc',$util_min, PDO::PARAM_INT);
					$query8 -> bindParam(':certif', $tab_certif[$p], PDO::PARAM_INT);
					$query8 -> execute();
					$query8 -> closeCursor();

					$query9 = $bdd -> prepare("SELECT COUNT(ID_TICKET) as NB_TK FROM ticket WHERE ID_CERTIF =:certif ");
					$query9 -> bindParam(':certif', $tab_certif[$p], PDO::PARAM_INT);
					$query9 -> execute();
					
					while($data2 = $query9 -> fetch()){

						$count += $data2['NB_TK'];
					}
					$query9 -> closeCursor();

				}
				
				$query10 = $bdd -> prepare("SELECT COMPTE FROM utilisateur WHERE ID_UTIL=:utilc");
				$query10 -> bindParam(':utilc',$util_min, PDO::PARAM_INT);
				$query10 -> execute();
				$data10 = $query10->fetch();
				
				$compte = $data10['COMPTE'];
				
				$query10 -> closeCursor();
				
				$count += $compte;

				$query11 = $bdd -> prepare("UPDATE utilisateur SET COMPTE=:cpt WHERE ID_UTIL=:utilc");
				$query11 -> bindParam(':cpt', $count, PDO::PARAM_INT);
				$query11 -> bindParam(':utilc',$util_min, PDO::PARAM_INT);
				$query11 -> execute();
				$query11 -> closeCursor();

				Journalisation(0,2,$id_bord,$util_min,$bdd);

				$query12 = $bdd -> prepare("SELECT NOM, PRENOM FROM utilisateur WHERE ID_UTIL=:util");
				$query12 -> bindParam(':util', $util_min, PDO::PARAM_INT);
				$query12 -> execute();
				$data4 = $query12 -> fetch();

				$result[1] = $data4['NOM'].' '.$data4['PRENOM'];
				$query12 -> closeCursor();
			}
			else{
				
				$query14 = $bdd -> prepare("SELECT ID_UTIL, COMPTE FROM utilisateur WHERE TYPE_COMPTE = 2 AND STAT_COMPTE = 0 AND ID_VILLE=:vil AND ID_UTIL<>:util ORDER BY COMPTE LIMIT 1");
				$query14 -> bindParam(':vil', $ville, PDO::PARAM_INT);
				$query14 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
				$query14 -> execute();
				$rows14 = $query14 -> rowCount();
				
				if($rows14 >= 1){
					
					$data14 = $query14 -> fetch();
					$util_min = $data14['ID_UTIL'];
					
					$count=0;
					
					for($p = 0; $p < $j; $p++){

						$query15 = $bdd -> prepare("UPDATE certificat SET STADE=:st, ID_USER_PREC=:util,ID_USER_COUR=:utilc WHERE ID_CERTIF =:certif");
						$query15 -> bindParam(':st', $step, PDO::PARAM_INT);
						$query15 -> bindParam(':util', $util, PDO::PARAM_INT);
						$query15 -> bindParam(':utilc',$util_min, PDO::PARAM_INT);
						$query15 -> bindParam(':certif', $tab_certif[$p], PDO::PARAM_INT);
						$query15 -> execute();
						$query15 -> closeCursor();

						$query16 = $bdd -> prepare("SELECT COUNT(ID_TICKET) as NB_TK FROM ticket WHERE ID_CERTIF =:certif");
						$query16 -> bindParam(':certif', $tab_certif[$p], PDO::PARAM_INT);
						$query16 -> execute();
						
						while($data16 = $query16->fetch()){

							$count+= $data16['NB_TK'];
						}
						$query16->closeCursor();
					}
					
					$count += $data14['COMPTE'] ;
					
					$query14 -> closeCursor();
					
					$query17 = $bdd -> prepare("UPDATE utilisateur SET COMPTE=:cpt WHERE ID_UTIL=:utilc");
					$query17 -> bindParam(':cpt', $count, PDO::PARAM_INT);
					$query17 -> bindParam(':utilc',$util_min, PDO::PARAM_INT);
					$query17 -> execute();
					$query17->closeCursor();

					Journalisation(0,2,$id_bord,$util_min,$bdd);

					$query18 = $bdd -> prepare("SELECT NOM, PRENOM FROM utilisateur WHERE ID_UTIL=:util");
					$query18 -> bindParam(':util', $util_min, PDO::PARAM_INT);
					$query18 -> execute();
					$data18 = $query18 -> fetch();

					$result[1] = $data18['NOM'].' '.$data18['PRENOM'];
					$query18 -> closeCursor();
				}
				else{
					
					$result[0] = 1 ;
				}
			}
		}		
		return $result;
	}
?>