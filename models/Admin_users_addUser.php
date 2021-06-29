<?php

	include_once('../config/Connexion.php');
	
	$tab[0] = 0;
	
	if(!empty($_POST['matr'])){
		
		$query = $bdd -> prepare("SELECT COUNT(ID_UTIL) AS NB FROM utilisateur WHERE MATRICULE =:matr");
		$query -> bindParam(':matr',$_POST['matr'], PDO::PARAM_INT);
		$query -> execute();
		$data = $query -> fetch();
		
		if($data['NB'] > 0){
			
			$tab[0] = 1;
		}
		else{
			
			$bool = 1;
			$j = 0;
			$lengthname = strlen($_POST['firstname'])-1;
			
			while($bool > 0){
				
				$j++;
				$login = strtolower(substr($_POST['firstname'] , 0,$j)).strtolower($_POST['name']);
				$query2 = $bdd -> prepare("SELECT ID_UTIL FROM utilisateur WHERE LOGIN =:log");
				$query2 -> bindParam(':log',$login, PDO::PARAM_STR);
				$query2 -> execute();
				$bool = $query2 -> rowCount();
				$query2 -> closeCursor();
				
				if($j == $lengthname){
					$check = false;
					break;
					$tab[0] = 3;
				}
				else{
					$check = true;
				}
			}
			
			if($check === true){
				
				$name = strtoupper($_POST['name']);
				$firstname = strtoupper($_POST['firstname']);
				$mail = strtolower($_POST['mail']);
				
				$query1 = $bdd -> prepare("INSERT INTO utilisateur(MATRICULE, LOGIN, NOM, PRENOM, ROLE_ADMIN, ID_VILLE, CONTACT, EMAIL, TYPE_COMPTE) VALUES (:matr,:log,:nom,:pren,0,:vil,:cont,:mail,:cel)");
				$query1 -> bindParam(':matr',$_POST['matr'], PDO::PARAM_INT);
				$query1 -> bindParam(':log', $login, PDO::PARAM_STR);
				$query1 -> bindParam(':nom', $name, PDO::PARAM_STR);
				$query1 -> bindParam(':pren', $firstname, PDO::PARAM_STR);
				$query1 -> bindParam(':vil', $_POST['town'], PDO::PARAM_INT);
				$query1 -> bindParam(':cont', $_POST['phone'], PDO::PARAM_STR);
				$query1 -> bindParam(':mail', $mail, PDO::PARAM_STR);
				$query1 -> bindParam(':cel', $_POST['cel'], PDO::PARAM_INT);
				$query1 -> execute();
				$query1 -> closeCursor();
				
				$tab[0] = 2;
			}
		}
		$query -> closeCursor();
	} 	

	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
	
?>