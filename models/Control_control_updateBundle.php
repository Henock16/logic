<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	session_start();

	include_once('../config/Connexion.php');
	include_once('../functions/Dispatching_function.php');
	include_once('../functions/Journalisation_function.php');
	
	$queryrejet = $bdd -> prepare("SELECT ID_CERTIF FROM certificat WHERE STATUT = 3 AND NUM_PCKLIST = :numpk AND BLOCKED = 0 AND DISABLED = 0 AND A_R IN(0,2) ORDER BY DATE_CREATION DESC LIMIT 1");
	$queryrejet -> bindParam(':numpk', $_POST['numpklist'], PDO::PARAM_STR);
	$queryrejet -> execute();
	$row = $queryrejet -> rowCount();
	
	if($row > 0){
		
		$tab[0] = 'rejet';
	}
	else{
		$libel='Niveaux de controle';
		
		$query = $bdd -> prepare("SELECT VALEUR FROM configuration WHERE LIBELLE =:lib AND VILLE =:vil");
		$query -> bindParam(':lib', $libel, PDO::PARAM_STR);
		$query -> bindParam(':vil', $_SESSION['ID_VILLE'], PDO::PARAM_INT);
		$query -> execute();
		$data = $query -> fetch();
		
		//Récupération de l'identifiant du certificat
		$query1 = $bdd -> prepare("SELECT ID_CERTIF, STADE, ID_PROD, ID_VILLE, NUM_CERTIF FROM certificat WHERE NUM_PCKLIST=:pklist AND A_R IN(0,2) AND DISABLED=0 AND BLOCKED = 0 AND STATUT <>3 ORDER BY DATE_CREATION DESC LIMIT 1");
		$query1 -> bindParam(':pklist', $_POST['numpklist'], PDO::PARAM_STR);
		$query1 -> execute();
		$data1 = $query1 -> fetch();
		
		$gap = $data1['STADE'] - $data['VALEUR'];
		
		$query -> closeCursor();	
		if((isset($_POST['rapemp'])) && (!empty($_POST['rapemp']))){
		//if(isset($_POST['rapemp'])){

				$numemp = $_POST['rapemp'];
				
				$query12 = $bdd->prepare("UPDATE certificat SET NUM_RAP_EMP =:numemp WHERE ID_CERTIF=:ct");
				$query12 -> bindParam(':numemp', $numemp, PDO::PARAM_INT);
				$query12 -> bindParam(':ct', $data1['ID_CERTIF'], PDO::PARAM_INT);
				$query12 -> execute();
				$query12 -> closeCursor();
				
				$query13 = $bdd -> prepare("UPDATE certificat SET ID_MODIFICATEUR=:util, DATE_MODIFICATION = now() WHERE ID_CERTIF =:certif");
				$query13 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
				$query13 -> bindParam(':certif', $data1['ID_CERTIF'], PDO::PARAM_INT);
				$query13 -> execute();
				$query13 -> closeCursor();
				
				$_POST['rapemp'] = null;
			}
		
		//if(($gap > 0)&&(empty($data1['NUM_CERTIF']))){
		if($gap > 0){
			
			$tab[0] = 3;
			$tab[1] = $_POST['numpklist'] ;
			$tab[2] = $_SESSION['ID_UTIL'];
			$an = date('Y');
			$y = 0;
			$j = 0;
			
			if(empty($data1['NUM_CERTIF'])){
				
				$query2 = $bdd -> prepare("SELECT INCRE_PROD, ID_INCRE FROM increment WHERE ANNEE=:an AND PRODUIT =:prod");
				$query2 -> bindParam(':an',$an, PDO::PARAM_STR);
				$query2 -> bindParam(':prod',$data1['ID_PROD'], PDO::PARAM_INT);
				$query2 -> execute();
				$rows2 = $query2 -> rowCount();
				$data2 = $query2 -> fetch();

				if($rows2 >= 1){

					$y = $data2['INCRE_PROD'] + 1;

					$query3 = $bdd -> prepare("UPDATE increment SET INCRE_PROD=:num WHERE ID_INCRE=:id");
					$query3-> bindParam(':num', $y, PDO::PARAM_INT);
					$query3-> bindParam(':id', $data2['ID_INCRE'], PDO::PARAM_INT);
					$query3 -> execute();
					$query3 -> closeCursor();

					$query4 = $bdd -> prepare("SELECT INCRE_VILLE,ID_SINCRE FROM sous_increment WHERE ville =:vil");
					$query4 -> bindParam(':vil',$data1['ID_VILLE'], PDO::PARAM_INT);
					$query4 -> execute();
					$rows4 = $query4 -> rowCount();
					$data4 = $query4 -> fetch();

					if($rows4 >= 1){

						$j = $data4['INCRE_VILLE']+ 1;

						$query5 = $bdd -> prepare("UPDATE sous_increment SET INCRE_VILLE=:num WHERE ID_SINCRE=:id");
						$query5-> bindParam(':num', $j, PDO::PARAM_INT);
						$query5-> bindParam(':id', $data4['ID_SINCRE'], PDO::PARAM_INT);
						$query5 -> execute();	
						$query5 -> closeCursor();
					}
					else{

						$j++;	
						$query6 = $bdd->prepare("INSERT INTO sous_increment (VILLE,INCRE_VILLE)VALUES(:vil,:num)");
						$query6-> bindParam(':vil', $data1['ID_VILLE'], PDO::PARAM_INT);
						$query6-> bindParam(':num', $j, PDO::PARAM_INT);
						$query6 -> execute();
						$query6 ->closeCursor();
					}
					$query4 -> closeCursor();
				}
				else{

					$y++;
					
					$query7 = $bdd -> prepare("INSERT INTO increment (PRODUIT,INCRE_PROD,ANNEE)VALUES(:prod,:num,:an)");
					$query7 -> bindParam(':prod', $data1['ID_PROD'], PDO::PARAM_INT);
					$query7 -> bindParam(':num', $y, PDO::PARAM_INT);
					$query7 -> bindParam(':an', $an, PDO::PARAM_INT);
					$query7 -> execute();
					$query7 -> closeCursor();

					$j++;
					
					$query8 = $bdd -> prepare("INSERT INTO sous_increment (VILLE,INCRE_VILLE)VALUES(:vil,:num)");
					$query8 -> bindParam(':vil', $data1['ID_VILLE'], PDO::PARAM_INT);
					$query8 -> bindParam(':num', $j, PDO::PARAM_INT);
					$query8 -> execute();
					$query8 -> closeCursor();

				}
				$query2 -> closeCursor();
				
				$query9 = $bdd -> prepare("SELECT ABREVIATION FROM VILLE WHERE ID_VILLE =:vil");
				$query9 -> bindParam(':vil',$data1['ID_VILLE'], PDO::PARAM_INT);
				$query9 -> execute();
				$data9 = $query9 -> fetch();
				$vil = $data9['ABREVIATION'];
				$query9 -> closeCursor();

				$query10 = $bdd -> prepare("SELECT LIBELLE FROM PRODUIT WHERE ID_PROD =:prod");
				$query10 -> bindParam(':prod',$data1['ID_PROD'], PDO::PARAM_INT);
				$query10 -> execute();
				$data10 = $query10 -> fetch();
				$prod = $data10['LIBELLE'];
				$query10 -> closeCursor();

				$numcertif = 'CCI/'.$vil.'/'.$prod.'/'.$an.'-'.$y;
				$tab[3] = $numcertif;
				$numcert=$numcertif;
			}
			else{
				$tab[3] = $data1['NUM_CERTIF'];
				$numcert=$data1['NUM_CERTIF'];
			}
				
				
				$query11 = $bdd -> prepare("UPDATE certificat SET  NUM_CERTIF=:numct, ID_USER_PREC=:userc, ID_USER_COUR = 0, STATUT = 2, AUTH_CERTIF = 0, CHANG_STAT = 0 WHERE ID_CERTIF=:ct");
				$query11 -> bindParam(':numct', $numcert, PDO::PARAM_STR);
				$query11 -> bindParam(':ct', $data1['ID_CERTIF'], PDO::PARAM_INT);
				$query11 -> bindParam(':userc', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
				$query11 -> execute();
				$query11 -> closeCursor();
				
				Journalisation($_SESSION['ID_UTIL'],3,$data1['ID_CERTIF'],0,$bdd);
		}
		else{
			
			

			$query14 = $bdd -> prepare("SELECT ID_ERR FROM erreur WHERE RESOLVED = 1 AND ID_CERTIF=:ct");
			$query14 -> bindParam(':ct', $data1['ID_CERTIF'], PDO::PARAM_INT);
			$query14 -> execute();
			$rows14 = $query14 -> rowcount();
			$query14 -> closeCursor();

			if($rows14 == 0){

				$tab[0] = 0 ;
				
				$query25 = $bdd -> prepare("UPDATE ticket SET CONTROLLED = 0 WHERE ID_CERTIF=:ct");
				$query25 -> bindParam(':ct', $data1['ID_CERTIF'], PDO::PARAM_INT);
				$query25 -> execute();
				$query25 -> closeCursor();
				
				$query15 = $bdd -> prepare("SELECT ID_BORD FROM bordereau WHERE ID_USER =:util AND STATUT= 0 ORDER BY ID_BORD DESC LIMIT 1");
				$query15 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
				$query15 -> execute();
				$rows15 = $query15 -> rowCount();
				$data15 = $query15 -> fetch();

				if($rows15 >= 1){

					$tab[1] = 0 ;

					$query16 = $bdd -> prepare("INSERT INTO certif_bord(ID_BORD,ID_CERTIF) VALUES(:bd,:ct)");
					$query16 -> bindParam(':bd', $data15['ID_BORD'], PDO::PARAM_INT);
					$query16 -> bindParam(':ct', $data1['ID_CERTIF'], PDO::PARAM_INT);
					$query16 -> execute();
					$query16 -> closeCursor();

					$query17 = $bdd -> prepare("UPDATE certificat SET STADE = 7 WHERE ID_CERTIF=:idcertif");
					$query17 -> bindParam(':idcertif', $data1['ID_CERTIF'], PDO::PARAM_INT);
					$query17 -> execute();
					$query17 -> closeCursor();

					$query18 = $bdd -> prepare("SELECT COUNT(ID_CB) as NB_LIASSE FROM certif_bord WHERE ID_BORD =:bd");
					$query18 -> bindParam(':bd', $data15['ID_BORD'], PDO::PARAM_INT);
					$query18 -> execute();
					$data18 = $query18->fetch();

					$query19 = $bdd -> query("SELECT VALEUR FROM configuration WHERE ID_CONF = 4");
					$data19 = $query19 -> fetch();

					if($data18['NB_LIASSE'] >= $data19['VALEUR']){

						$tab[2] = 0 ;
						
						$step = ($data1['STADE'] + 1) ;
						
						$result = Dispatching($data15['ID_BORD'],$step,$_SESSION['ID_UTIL'],$_SESSION['ID_VILLE'],$bdd);

						if($result[0] == 0){

							$tab[3] = 0 ;
							$tab[4] = $result[1] ;
						}
						elseif($result[0] == 1){

							$tab[3] = 1 ;
						}
					}
					else{

						$tab[2] = 1 ;
					}
					$query19 -> closeCursor();
					$query18 -> closeCursor();
				}
				else{

					$tab[1] = 1 ;

					$query20 = $bdd -> prepare("INSERT INTO bordereau(ID_USER,STADE) VALUES(:util,:stad)");
					$query20 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
					$query20 -> bindParam(':stad',$data1['STADE'], PDO::PARAM_INT);
					$query20 -> execute();
					$query20 -> closeCursor();

					$query21 = $bdd -> prepare("SELECT ID_BORD FROM bordereau WHERE ID_USER =:util AND STATUT = 0 ORDER BY ID_BORD DESC LIMIT 1");
					$query21 -> bindParam(':util', $_SESSION['ID_UTIL'], PDO::PARAM_INT);
					$query21 -> execute();
					$data21 = $query21 -> fetch();

					$query22 = $bdd -> prepare("INSERT INTO certif_bord(ID_BORD,ID_CERTIF) VALUES(:bd,:ct)");
					$query22 -> bindParam(':bd', $data21['ID_BORD'], PDO::PARAM_INT);
					$query22 -> bindParam(':ct', $data1['ID_CERTIF'], PDO::PARAM_INT);
					$query22 -> execute();
					$query22 -> closeCursor();

					$tab[2] = $data21['ID_BORD'];

					$query23 = $bdd -> prepare("UPDATE certificat SET STADE = 7 WHERE ID_CERTIF=:idcertif");
					$query23 -> bindParam(':idcertif', $data1['ID_CERTIF'], PDO::PARAM_INT);
					$query23 -> execute();
					$query23 -> closeCursor();

					$query21 -> closeCursor();
				}
				$query15 -> closeCursor();
			}
			else{

				$tab[0] = 1 ;

				$query24 = $bdd->prepare("UPDATE certificat SET ERREUR = 1 WHERE ID_CERTIF=:ct");
				$query24 -> bindParam(':ct', $data1['ID_CERTIF'], PDO::PARAM_INT);
				$query24 -> execute();
				$query24 -> closeCursor();
			}
		}
		$query1 -> closeCursor();
	}
	
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>