<?php

	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');

	session_start();
	
	include('../config/Connexion.php');
 
	$username = $_POST['username'];
	$password = $_POST['password'];
	$today = date('Y-m-d');

	$query = $bdd -> prepare("SELECT ID_UTIL, NOM, PRENOM, MATRICULE, EMAIL, CONTACT, STAT_COMPTE, DERN_ACTION, PREM_CONNEXION, TYPE_COMPTE, ID_VILLE, ROLE_ADMIN, AVATAR, DATE_CREATION FROM utilisateur WHERE BINARY LOGIN=:user AND BINARY PASS=:mp");
	$query -> bindParam(':user', $username, PDO::PARAM_STR);
	$query -> bindParam(':mp', $password, PDO::PARAM_STR);
	$query -> execute();
	
	$rows = $query -> rowCount();
	
	if($rows > 0){
		
		while($data = $query -> fetch()){
			
			$interval = (time()-3600) - $data['DERN_ACTION'] ;
			
			if($data['STAT_COMPTE'] == 1){
				
				$result['0'] = 1 ;
			}
			elseif(($data['DERN_ACTION'] > 0) && ($interval < 300)){
				
				$result['0'] = 2 ;
			}
			elseif($data['PREM_CONNEXION'] == 0){
				
				$result['0'] = 3 ;
				$result['1'] = $data['NOM'].' '.$data['PRENOM'];
				
				$_SESSION['ID_UTIL'] = $data['ID_UTIL'] ;
			}
			else{
				
				$result['0'] = 5 ;
				
				$_SESSION['ID_UTIL'] = $data['ID_UTIL'];
				$_SESSION['CONNECT'] = 1 ;
				$_SESSION['TYPE_COMPTE'] = $data['TYPE_COMPTE'];
				$_SESSION['ID_VILLE'] = $data['ID_VILLE'] ;
				$_SESSION['FULLNAME'] = $data['NOM'].' '.$data['PRENOM'] ;
				$_SESSION['AVATAR'] = $data['AVATAR'] ;
				$_SESSION['DATE'] = substr($data['DATE_CREATION'], 0, 4) ;
				$_SESSION['LOGIN'] = $_POST['username'];
				$_SESSION['MATRICULE'] = $data['MATRICULE'] ;
				$_SESSION['EMAIL'] = $data['EMAIL'] ;
				$_SESSION['CONTACT'] = $data['CONTACT'] ;				
				$_SESSION['ROLE'] = $data['ROLE_ADMIN'] ;
				
				if($data['TYPE_COMPTE'] == 0){
					$_SESSION['FUNCTION'] = 'Administration';
				}
				else{
					
					$query4 = $bdd -> query("SELECT LIBELLE FROM poste_travail WHERE IDENTIFIANT =".$data['TYPE_COMPTE']);
					$data4 = $query4 -> fetch();
					
					$_SESSION['FUNCTION'] = $data4['LIBELLE'];

					$query4 -> closeCursor();
				}

				$dern_action = time() - 3600 ;
				$query1 = $bdd -> prepare("UPDATE utilisateur SET DERN_ACTION =:time WHERE ID_UTIL=:id");
				$query1 -> bindParam(':id', $data['ID_UTIL'], PDO::PARAM_INT);
				$query1 -> bindParam(':time', $dern_action, PDO::PARAM_INT);
				$query1 -> execute();
				$query1 -> closeCursor();
				
				$query2 = $bdd -> prepare("SELECT LIBELLE FROM ville WHERE ID_VILLE=:idville");
				$query2 -> bindParam(':idville', $_SESSION['ID_VILLE'], PDO::PARAM_INT);
				$query2 -> execute();
				$data2 = $query2 -> fetch();
				
				$_SESSION['LIB_VILLE'] = $data2['LIBELLE'];

				$query2 -> closeCursor();
			}
		}
	}
	else{
		
		$result['0'] = 0 ;
	}
	$query->closeCursor();
	
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($result) ;
?>