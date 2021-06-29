<?php
    global $NumAR;
    global $Prod;
	
    function dateFr($date){
    	return strftime('%d/%m/%Y',strtotime($date));
    }
	
	function getNum($numpack){
        $bool = true ;
        $i = -1;
        $number = "";
		
        while($bool){
			
            $number = substr($numpack, $i);
            if(is_numeric($number)){
                $bool = true ;
                $i-- ;
            }
            else{
                $i += 2 ;
                $number = substr($numpack, $i);
                $bool = false ;
            }
        }
        return $number ;
    }

    $query = $bdd -> prepare("SELECT NUM_PCKLIST, ID_CAMP, ID_REC, ID_PROD, ID_TRANSIT, NUM_DOSS, NUM_INST_CLI, NUM_INST_FOUR, CLIENT, DEB_EMP, FIN_EMP, NAVIRE, NOM_SOUM, PREN_SOUM, FONCT_SOUM, TEL_SOUM, ID_DEMANDEUR, ID_TYPPROD, ID_EXP, ID_EGRE, ID_DEST, NUM_OT, A_R, ID_A_R FROM certificat WHERE ID_CERTIF =:idcertif");
	$query -> bindParam(':idcertif', $_GET['egasilocedetsil'], PDO::PARAM_INT);
	$query -> execute();	

    while ($data = $query -> fetch()){
		
		$query1 = $bdd -> query("SELECT LIBELLE FROM campagne WHERE ID_CAMP =".$data['ID_CAMP']);
		$data1 = $query1 -> fetch();
		$Camp = $data1['LIBELLE'];
		$query1 -> closeCursor();
		
		$query2 = $bdd -> query("SELECT LIBELLE FROM recolte WHERE ID_REC =".$data['ID_REC']);
		$data2 = $query2 -> fetch();
		$Recol = $data2['LIBELLE'];
		$query2 -> closeCursor();
		
		$query3 = $bdd -> query("SELECT LIBELLE FROM produit WHERE ID_PROD =".$data['ID_PROD']);
		$data3 = $query3 -> fetch();
		$Type = $data3['LIBELLE'];
		$query3 -> closeCursor();
		
		$query4 = $bdd -> query("SELECT LIBELLE FROM transitaire WHERE ID_TRANSIT =".$data['ID_TRANSIT']);
		$data4 = $query4 -> fetch();
		$Trans = $data4['LIBELLE'];
		$query4 -> closeCursor();
		
		$query5 = $bdd -> query("SELECT PORT, PAYS FROM destination WHERE ID_DEST =".$data['ID_DEST']);
		$data5 = $query5 -> fetch();
		$Destin = $data5['PORT']." / ".$data5['PAYS'];
		$query5 -> closeCursor();
		
		$query6 = $bdd -> query("SELECT LIBELLE FROM exportateur WHERE ID_EXP =".$data['ID_EXP']);
		$data6 = $query6 -> fetch();
		$Expor = $data6['LIBELLE'];
		$query6 -> closeCursor();
		
		$query7 = $bdd -> query("SELECT LOGO FROM demandeur WHERE ID_DEMAND =".$data['ID_DEMANDEUR']);
		$data7 = $query7 -> fetch();
		$Logo = $data7['LOGO'];
		$query7 -> closeCursor();
		
		$query8 = $bdd -> query("SELECT LIBELLE FROM type_produit WHERE ID_TYPPROD =".$data['ID_TYPPROD']);
		$data8 = $query8 -> fetch();
		$TP = $data8['LIBELLE'];
		$query8 -> closeCursor();
		
		$List = $data['NUM_PCKLIST'];
		$Doss = $data['NUM_DOSS'];
		$Client = $data['NUM_INST_CLI'];
		$Four = $data['NUM_INST_FOUR'];
		$Dest = $data['CLIENT'];
		$Nav = $data['NAVIRE'];
		$OT = $data['NUM_OT'];
		$DateD = dateFr($data['DEB_EMP']);
		$DateF = dateFr($data['FIN_EMP']);
		$Nom = $data['NOM_SOUM'];
		$Pren = $data['PREN_SOUM'];
		$Fonc = $data['FONCT_SOUM'];
		$Tel = $data['TEL_SOUM'];
		$Prod = $data['ID_PROD'];
		$_SESSION['A_R'] = $data['A_R'];
		
		if($Prod == 2){
			
			$query9 = $bdd -> query("SELECT LIBELLE FROM egreneur WHERE ID_EGRE =".$data['ID_EGRE']);
			$data9 = $query9 -> fetch();
			$Egren = $data9['LIBELLE'];
			$query9 -> closeCursor();
		}
		
		if($data['A_R'] == 2){
			
			$query10 = $bdd -> query("SELECT NUM_PCKLIST FROM certificat WHERE ID_PCKLIST =".$data['ID_A_R']);
			$data10 = $query10 -> fetch();
			$NumAR = getNum($data10['NUM_PCKLIST']);
			$query10 -> closeCursor();
		}
    }
    $query -> closeCursor();
?>