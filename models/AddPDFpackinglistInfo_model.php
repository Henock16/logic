<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
	
   session_start();

    include_once('../config/Connexion.php');

    global $numar;
    
    function dateFr($date){
    	return strftime('%d/%m/%Y',strtotime($date));
    }
    
    function getNumPack($numpack){
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
    	
    $jour= date("Y-m-d"); 
    	
    $reponse=$bdd->query("SELECT NUM_PCKLIST, ID_CAMP, ID_REC, ID_TYPPROD, ID_TRANSIT, NUM_DOSS, NUM_INST_CLI, NUM_INSTFOUR_COTON, CLIENT, DATE_DEBUT_EMP, DATE_FIN_EMP, NAVIRE, NOM_SOUMETTEUR, PRENOM_SOUMETTEUR, FONCTION_SOUMETTEUR, TELEPHONE_SOUMETTEUR, ID_PROD, ID_EXP, ID_EGRE, ID_DEST, NUM_OT, ID_DEMANDEUR, A_R, ID_A_R FROM certificat WHERE ID_CERTIF=".$_POST['']);

    while ($don = $reponse->fetch()){
    	 $List=$don['NUM_PCKLIST'];
    	 $Camp=$don['ID_CAMP'];
    	 $Recol=$don['ID_REC'];
    	 $Type=$don['ID_TYPPROD'];
    	 $Trans=$don['ID_TRANSIT'];
    	 $Doss=$don['NUM_DOSS'];
    	 $Client=$don['NUM_INST_CLI'];
    	 $Four=$don['NUM_INSTFOUR_COTON'];
    	 $Dest=$don['CLIENT'];
    	 $DateD=dateFr($don['DATE_DEBUT_EMP']);
    	 $DateF=dateFr($don['DATE_FIN_EMP']);
    	 $Nav=$don['NAVIRE'];
    	 $Nom=$don['NOM_SOUMETTEUR'];
    	 $Pren=$don['PRENOM_SOUMETTEUR'];
    	 $Fonc=$don['FONCTION_SOUMETTEUR'];
    	 $Tel=$don['TELEPHONE_SOUMETTEUR'];
    	 $TP=$don['ID_PROD'];
    	 $Exp=$don['ID_EXP'];
    	 $Egr=$don['ID_EGRE'];
    	 $Desti=$don['ID_DEST'];
    	 $OT=$don['NUM_OT'];
    	 $_SESSION['id_user']=$don['ID_DEMANDEUR'];
    	 $_SESSION['ar'] = $don['A_R'];
    	 $_SESSION['idar'] = $don['ID_A_R'];
    }
    $reponse->closeCursor();
    
    $reponse1=$bdd->query("SELECT LIBELLE FROM exportateur WHERE IDENTIFIANT=".$Exp);
    while ($don1 = $reponse1->fetch()){
        $Expor=$don1['LIBELLE'];
    }
    $reponse1->closeCursor();
    
	if(isset($_SESSION['TP']) && !empty($_SESSION['TP'])){
		if($_SESSION['TP']==2){
			$reponse2=$bdd->query("SELECT LIBELLE FROM egreneur WHERE IDENTIFIANT=".$Egr);
			
			while ($don2 = $reponse2->fetch()){
				$Egren=$don2['LIBELLE'];
			}
			$reponse2->closeCursor();
		}
    }
	
	if(isset($_GET['tp']) && !empty($_GET['tp'])){
		if($_GET['tp']==2){
			$reponse2=$bdd->query("SELECT LIBELLE FROM egreneur WHERE IDENTIFIANT=".$Egr);
			
			while ($don2 = $reponse2->fetch()){
				$Egren=$don2['LIBELLE'];
			}
			$reponse2->closeCursor();
		}
    }
    
    $reponse3=$bdd->query("SELECT PORT, PAYS FROM destination WHERE IDENTIFIANT=".$Desti);
    while ($don3 = $reponse3->fetch()){
        $Destin=$don3['PORT']." / ".$don3['PAYS'];
    }
    $reponse3->closeCursor();
    
    $reponse4=$bdd->query("SELECT LOGO FROM user WHERE IDENTIFIANT=".$_SESSION['id_user']);
    while ($don4 = $reponse4->fetch()){
        $Logo=$don4['LOGO'];
    }
    $reponse4->closeCursor();
    
    if(is_numeric($Trans)){
    
        $reponse5=$bdd->query("SELECT LIBELLE FROM transitaire WHERE IDENTIFIANT=".$Trans);
        while ($don5 = $reponse5->fetch()){
            $Trans=$don5['LIBELLE'];
        }
        $reponse5->closeCursor();
    }
    
    if(is_numeric($Camp)){
    
        $reponse6=$bdd->query("SELECT LIBELLE FROM campagne WHERE ID_CAMP=".$Camp);
        while ($don6 = $reponse6->fetch()){
            $Camp=$don6['LIBELLE'];
        }
        $reponse6->closeCursor();
    }
    
    if(is_numeric($Recol)){
    
        $reponse7=$bdd->query("SELECT LIBELLE FROM recolte WHERE ID_REC=".$Recol);
        while ($don7 = $reponse7->fetch()){
            $Recol=$don7['LIBELLE'];
        }
        $reponse7->closeCursor();
    }
    
    if(is_numeric($Type)){
    
        $reponse8=$bdd->query("SELECT LIBELLE FROM type_produit WHERE ID_TYPPROD=".$Type);
        while ($don8 = $reponse8->fetch()){
            $Type=$don8['LIBELLE'];
        }
        $reponse8->closeCursor();
    }
    
    if(!empty($_SESSION['idar'])){
        $reponse5=$bdd->query("SELECT NUM_PACKLIST FROM packing_list WHERE IDENTIFIANT=".$_SESSION['idar']);
        while ($don5 = $reponse5->fetch()){
            $num = $don5['NUM_PACKLIST'];
            $numar = getNumPack($num);
        }
        $reponse5->closeCursor();
    }
?>