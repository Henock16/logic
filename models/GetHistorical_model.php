<?php
	ini_set('session.gc_maxlifetime','28800');
	//ini_set('session.save_path','c:/wamp/sessions');
    session_start();

    include_once('../config/Connexion.php');
    include_once('../functions/Date_management_function.php');

    $i =0 ;
    global $bool;
    global $dAction;
    $bool=false;

    $tab[0]=0;
    $i++;

    $nb_cert=0;
    $query = $bdd ->query("SELECT ID_CERTIF FROM certificat WHERE STATUT IN (3,4) AND ID_CAMP IN(SELECT ID_CAMP FROM campagne WHERE STATUT =0) ");

    while($data = $query->fetch()){

        $query8= $bdd ->prepare("SELECT DATE_CREATION FROM journal WHERE ACTION IN(4,5) AND CIBLE =:pckl ORDER BY DATE_CREATION DESC");
            $query8 -> bindParam(':pckl', $data['ID_CERTIF'], PDO::PARAM_INT);
            $query8 -> execute();

            while($data8 = $query8->fetch()){

                $dAction = $data8['DATE_CREATION'];
                $dServeur = date_create(date('Y-m-d H:i:s')); 
                $dComp = date_create($dAction);

                $nw = $dServeur -> format('U');
                $dt = $dComp -> format('U');

                $psed =($nw - $dt);

            if($psed>86400){
                $nb_cert+=1;

            }
    }
}
    $tab[$i]=$nb_cert;
    $i++;
    $query -> closeCursor();

    $query1 = $bdd ->query("SELECT ID_CERTIF, NUM_PCKLIST, STADE, STATUT, ID_VILLE, A_R, DISABLED, ID_EXP, ID_TYPPROD, DATE_CREATION  FROM certificat WHERE STATUT IN (3,4) AND ID_CAMP IN(SELECT ID_CAMP FROM campagne WHERE STATUT =0) ORDER BY DATE_CREATION DESC");

    while($data1 = $query1->fetch()){
		
            $datedebut=$data1['DATE_CREATION'];
            $query6= $bdd ->prepare("SELECT DATE_CREATION FROM journal WHERE ACTION IN(4,5) AND CIBLE =:pckl ORDER BY DATE_CREATION DESC");
            $query6 -> bindParam(':pckl', $data1['ID_CERTIF'], PDO::PARAM_INT);
            $query6 -> execute();

            while($data6 = $query6->fetch()){

                $dAction = $data6['DATE_CREATION'];
                $dServeur = date_create(date('Y-m-d H:i:s')); 
                $dComp = date_create($dAction);

                $nw = $dServeur -> format('U');
                $dt = $dComp -> format('U');

                $psed =($nw - $dt);

                if($psed>86400){

                 $bool=true;
                }
            }

            $query6 -> closeCursor();
        
        if($bool==true ){ 

            $tab[$i]= $data1['ID_CERTIF'];
            $i++;
            $tab[$i]= $data1['NUM_PCKLIST'];
            $i++;

            $query2= $bdd ->prepare("SELECT LIBELLE FROM type_produit WHERE ID_TYPPROD =:prod");
            $query2 -> bindParam(':prod', $data1['ID_TYPPROD'], PDO::PARAM_INT);
            $query2 -> execute();
            $data2 = $query2->fetch();
            $tab[$i]= $data2['LIBELLE'];
            $i++;
            $query2 -> closeCursor();

            $query3= $bdd ->prepare("SELECT LIBELLE FROM exportateur WHERE ID_EXP =:exp");
            $query3 -> bindParam(':exp', $data1['ID_EXP'], PDO::PARAM_INT);
            $query3 -> execute();
            $data3 = $query3->fetch();
            $tab[$i]= $data3['LIBELLE'];
            $i++;
            $query3 -> closeCursor();

            $tab[$i]= $data1['DATE_CREATION'];
            $i++;

            $poids=0;
            $query4= $bdd ->prepare("SELECT POIDS_NET FROM ticket WHERE ID_TICKET =:tck");
            $query4 -> bindParam(':tck', $data1['ID_CERTIF'], PDO::PARAM_INT);
            $query4 -> execute();
            while($data4 = $query4->fetch()){

                $poids+= $data4['POIDS_NET'];
            }
            $query4 -> closeCursor();

            $tab[$i]= $poids;
            $i++;
            $tab[$i]= $data1['STADE'];
            $i++;
            $tab[$i]= $data1['STATUT'];
            $i++;
            $tab[$i]= $data1['DISABLED'];
            $i++;

            $query5= $bdd ->prepare("SELECT LIBELLE FROM ville WHERE ID_VILLE =:vil");
            $query5 -> bindParam(':vil', $data1['ID_VILLE'], PDO::PARAM_INT);
            $query5 -> execute();
            $data5 = $query5->fetch();
            $tab[$i]= $data5['LIBELLE'];
            $i++;
            $query5 -> closeCursor();

                if($data1['DISABLED']==1){

                    $heur = "00";
                    $min = "00";
                    $sec = "00";

                    if($data1['A_R']==1){

                        $query7 = $bdd->prepare("SELECT NUM_PCKLIST FROM certificat WHERE ID_CERTIF =:pkl ");
                        $query7 -> bindParam(':pkl', $data1['ID_CERTIF'], PDO::PARAM_INT);
                        $query7 -> execute();
                        $data7 = $query7->fetch();
                        $tab[$i]= "Remplacé par ".$data1['NUM_PCKLIST'];
                        $i++;
                        $query7 -> closeCursor();
                    }

                    $tab[$i]=$heur.":".$min.":".$sec;
                    $i++;

                }
                else{

                     if($data1['STATUT']==3){

                        $tab[$i]="Rejeté";
                        $i++;

                    }
                    if($data1['STATUT']==4){

                        $tab[$i]="Transmis";
                        $i++;

                    }
                   
                        $dateServeur = date('Y-m-d', strtotime($dAction));
                        $dateComp = date('Y-m-d', strtotime($datedebut));

                        $dateServeur1 = $dAction;
                        
                        if($dateComp == $dateServeur){
                            $heur = diffHour($dAction, $dateServeur1)[0];
                            $min = diffHour($dAction, $dateServeur1)[1];
                            $sec = diffHour($dAction, $dateServeur1)[2];
                        }
                        else{
                            $heur = ((diffWorkDay($dateComp, $dateServeur) / 86400)-1)*8;
                            $heur += (calHourDep($dAction)[0]) ;
                            $heur += calHourFin($dateServeur1)[0] ;
                            $min = calHourDep($dAction)[1] ;
                            $min += calHourFin($dateServeur1)[1] ;
                            $sec = calHourDep($dAction)[2] ;
                            $sec += calHourFin($dateServeur1)[2] ;
                        }

                        while($sec >= 60){
                            $min++;
                            $sec -= 60;
                        }

                        while($min >= 60){
                            $heur++;
                            $min -= 60;
                        }

                    $tab[$i]=$heur.":".$min.":".$sec;
                    $i++;
                }
        }
    }
    $query1 -> closeCursor();

    $bdd = null;
    /* Output header */
    header('Content-type: application/json');
    echo json_encode($tab);

?>