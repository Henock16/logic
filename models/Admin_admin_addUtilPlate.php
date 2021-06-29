<?php
	include_once('../config/Connexion.php');
	
	$tab[0] = 0;
	
	if(!empty($_POST['structure'])){
		
		$structure = strtoupper($_POST['structure']);
		
		$query = $bdd -> prepare("SELECT COUNT(ID_DEMAND) AS NB FROM demandeur WHERE STRUCTURE LIKE CONCAT('%', :structure, '%') AND VILLE =:town");
		$query -> bindParam(':structure', $structure, PDO::PARAM_STR);
		$query -> bindParam(':town', $_POST['town'], PDO::PARAM_INT);
		$query -> execute();
		$data = $query -> fetch();
		
		if($data['NB'] >= 1){			
			$tab[0] = 1;
		}
		else{
			
			$query1 = $bdd -> query("SELECT LOGIN FROM demandeur ORDER BY ID_DEMAND DESC LIMIT 1");
			$data1 = $query1 -> fetch();
			
			$bool = true;
			$i = -1 ;
			while($bool){
				
				if(is_numeric(substr($data1['LOGIN'], $i))){
					$numb = substr($data1['LOGIN'], $i);
				}
				else{
					$bool = false;
				}
				$i -= 1;
			}
			$query1 -> closeCursor();
			
			if(strlen($structure) >= 6){
				$login = strtolower(substr($structure, 0, 5)).'ex'.($numb + 1);
			}
			else{
				$login = strtolower($structure).'ex'.($numb + 1);
			}
			
			$query2 = $bdd ->prepare("INSERT INTO demandeur (LOGIN, TYPE_OPERATEUR, STRUCTURE, VILLE, LOGO) VALUE (:log, :typop, :struct, :vil, :logo)");
			$query2 -> bindParam(':log', $login, PDO::PARAM_STR);
			$query2 -> bindParam(':typop', $_POST['typop'], PDO::PARAM_INT);
			$query2 -> bindParam(':struct', $structure, PDO::PARAM_STR);
			$query2 -> bindParam(':vil', $_POST['town'], PDO::PARAM_INT);
			$query2 -> bindParam(':logo', $_POST['logo'], PDO::PARAM_STR);
			$query2 -> execute();
			$query2 -> closeCursor();
			$tab[0] = 2;
		}
		$query -> closeCursor();
	}
	$bdd = null;
	
	/* Output header */
	header('Content-type: application/json');
	echo json_encode($tab);
?>