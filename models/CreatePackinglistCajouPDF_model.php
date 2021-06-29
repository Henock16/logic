<?php

	class PDF extends FPDF{

		function piedpage($n){

		    include('../assets/qrcode/qrcode.php');

			$this -> Ln(10);
			$this -> Image($tempDir.'/'.$fileName,10,265,25, 'png');
			$this -> Image('../assets/images/dupli.png', 160, 269, 40);

			if($_SESSION['A_R'] == 2){

				$this -> Image('../assets/images/a-r.png', 110, 269, 40);
				$this -> SetFont('Courier','B',10);
				$this -> Text(127,280, $n);
			}
		}

		function logo_entreprise($Logo){

			$this -> Rect(3,3, 204, 290);
			$this -> Image('../assets/images/logo_pcklist/'.$Logo, 10, 7, 45.00, 20.00);
			$this -> Image('../assets/images/cci.jpg', 140, 7, 60.00);
			$this -> SetFont('Courier','B',8);
			$this -> Ln(6);
			$this -> Cell(130,10,'',0,0,'C');
			$this -> Cell(60,10,'E-mail : cotoncajou@cci.ci',0,0,'C');
			$this -> Ln(4);
			$this -> Cell(130,10,'',0,0,'C');
			$this -> Cell(60,10,'Tel : +225 20 25 58 75',0,0,'C');
		}

		function info_expor($Nu,$Cp,$Rc,$Ex,$Pr,$Tr,$Ot,$Nd,$De,$Dd,$Df,$Dt,$Na){

			$border = 'LRTB';
			$this -> SetFont('Courier','B',10);
			$this -> Ln(15);
			$this -> Cell(0,10,utf8_decode('PACKING LIST N° ').$Nu,'B',0,'C');
			$this -> Ln(15);
			$this -> SetFont('Courier','B',8);
			$this -> Cell(35,5,'Campagne',$border,0,'L');
			$this -> SetFont('Courier','',8);
			$this -> Cell(55,5,$Cp,$border,0,'L');
			$this -> SetFillColor(255,255,255);
			$this -> Cell(10,5,'','L',0,'C',1);
			$this -> SetFont('Courier','B',8);
			$this -> Cell(35,5,'Exportateur',$border,0,'L');
			$this -> SetFont('Courier','',8);
			$this -> Cell(55,5,$Ex,$border,0,'L');
			$this -> Cell(5,5,'','L',0,'C',1);
			$this -> Ln();
			$this -> SetFont('Courier','B',8);
			$this -> Cell(35,5,utf8_decode('Récolte'),$border,0,'L');
			$this -> SetFont('Courier','',8);
			$this -> Cell(55,5,$Rc,$border,0,'L');
			$this -> Cell(10,5,'','L',0,'C',1);
			$this -> SetFont('Courier','B',8);
			$this -> Cell(35,5,'Destinataire',$border,0,'L');
			$this -> SetFont('Courier','',8);
			$this -> Cell(55,5,$De,$border,0,'L');
			$this -> Cell(5,5,'','L',0,'C',1);
			$this -> Ln();
			$this -> SetFont('Courier','B',8);
			$this -> SetFillColor(245,245,245);
			$this -> Cell(90,5,'','RLT',0,'L',1);
			$this -> SetFont('Courier','',8);
			$this -> SetFillColor(255,255,255);
			$this -> Cell(10,5,'','L',0,'C',1);
			$this -> SetFont('Courier','B',8);
			$this -> SetFillColor(245,245,245);
			$this -> Cell(90,5,'',$border,0,'L',1);
			$this -> SetFont('Courier','',8);
			$this -> SetFillColor(255,255,255);
			$this -> Cell(5,5,'','L',0,'C',1);
			$this -> Ln();
			$this -> SetFont('Courier','B',8);
			$this -> Cell(35,5,utf8_decode('N° Ordre de Transit'),$border,0,'L');
			$this -> SetFont('Courier','',8);
			$this -> Cell(55,5,$Ot,$border,0,'L');
			$this -> Cell(10,5,'','L',0,'C',1);
			$this -> SetFont('Courier','B',8);
			$this -> Cell(35,5,utf8_decode('Date début empotage'),$border,0,'L');
			$this -> SetFont('Courier','',8);
			$this -> Cell(55,5,$Dd,$border,0,'L');
			$this -> Cell(5,5,'','L',0,'C',1);
			$this -> Ln();
			$this -> SetFont('Courier','B',8);
			$this -> Cell(35,5,'Type de Produit',$border,0,'L');
			$this -> SetFont('Courier','',8);
			$this -> Cell(55,5,$Pr,$border,0,'L');
			$this -> Cell(10,5,'','L',0,'C',1);
			$this -> SetFont('Courier','B',8);
			$this -> Cell(35,5,'Date fin empotage',$border,0,'L');
			$this -> SetFont('Courier','',8);
			$this -> Cell(55,5,$Df,$border,0,'L');
			$this -> Cell(5,5,'','L',0,'C',1);
			$this -> Ln();
			$this -> SetFont('Courier','B',8);
			$this -> Cell(35,5,'Transitaire',$border,0,'L');
			$this -> SetFont('Courier','',8);
			$this -> Cell(55,5,$Tr,$border,0,'L');
			$this -> Cell(10,5,'','L',0,'C',1);
			$this -> SetFont('Courier','B',8);
			$this -> Cell(35,5,'Destination',$border,0,'L');
			$this -> SetFont('Courier','',8);
			$this -> Cell(55,5,$Dt,$border,0,'L');
			$this -> Cell(5,5,'','L',0,'C',1);
			$this -> Ln();
			$this -> SetFont('Courier','B',8);
			$this -> Cell(35,5,utf8_decode('N° Dossier'),$border,0,'L');
			$this -> SetFont('Courier','',8);
			$this -> Cell(55,5,$Nd,$border,0,'L');
			$this -> Cell(10,5,'','L',0,'C',1);
			$this -> SetFont('Courier','B',8);
			$this -> Cell(35,5,'Navire',$border,0,'L');
			$this -> SetFont('Courier','',8);
			$this -> Cell(55,5,$Na,$border,0,'L');
			$this -> Cell(5,5,'','L',0,'C',1);
			$this -> Ln(10);
		}

		function info_pesee($id){

			include('../config/Connexion.php');

			$i = 1;
			$border = 'LRTB';
			$pos = 'C';
			$border2 = 'LRT';
			$border3 = 'LRB';

			$somPb = 0;
			$somTc = 0;
			$somTh = 0;
			$somNb = 0;
			$somTb = 0;
			$somPn = 0;

			$this -> SetFont('Courier','B',8);
			$this -> SetFillColor(245,245,245);
			$this -> Cell(5,4,utf8_decode('N°'),$border2,0,'C',1);
			$this -> Cell(20,4,'Date',$border2,0,$pos,1);
			$this -> Cell(10,4,'Type',$border2,0,$pos,1);
			$this -> Cell(20,4,utf8_decode('N°'),$border2,0,$pos,1);
			$this -> Cell(30,4,utf8_decode('N° Plomb'),$border2,0,$pos,1);
			$this -> Cell(30,4,'Pont Bascule',$border2,0,$pos,1);
			$this -> Cell(18,4,'Poids',$border2,0,$pos,1);
			$this -> Cell(15,4,'Tare',$border2,0,$pos,1);
			$this -> Cell(12,4,'Tare',$border2,0,$pos,1);
			$this -> Cell(12,4,'Tare',$border2,0,$pos,1);
			$this -> Cell(18,4,'Poids',$border2,0,$pos,1);
			$this -> Ln();
			$this -> Cell(5,4,'',$border3,0,$pos,1);
			$this -> Cell(20,4,utf8_decode('Pesée'),$border3,0,$pos,1);
			$this -> Cell(10,4,'TCs',$border3,0,$pos,1);
			$this -> Cell(20,4,'Conteneur',$border3,0,$pos,1);
			$this -> Cell(30,4,'',$border3,0,$pos,1);
			$this -> Cell(30,4,'',$border3,0,$pos,1);
			$this -> Cell(18,4,'Brut',$border3,0,$pos,1);
			$this -> Cell(15,4,'TCs',$border3,0,$pos,1);
			$this -> Cell(12,4,'Sacs',$border3,0,$pos,1);
			$this -> Cell(12,4,'Hab',$border3,0,$pos,1);
			$this -> Cell(18,4,'Net(Kg)',$border3,0,$pos,1);
			$this -> Ln();
			$this -> SetFont('Courier','',8);

			$query = $bdd -> query("SELECT DATE_PESEE, NUM_CONTENEUR, NUM_PLOMB, SITE, POIDS_PRE_PESEE, POIDS_DEU_PESEE, TARE_CONT, POIDS_NET, TARE_EMB, NB_EMB, TARE_HAB FROM ticket WHERE ID_CERTIF =".$id);

			while ($data = $query -> fetch()){

				$query1 = $bdd -> query("SELECT LIBELLE FROM site WHERE ID_SITE =".$data['SITE']);
				$data1 = $query1 -> fetch();

				$site = $data1['LIBELLE'];

				$query1 -> closeCursor();

				if($data['TARE_CONT'] < 3000 ){
					$typecont = '20';
				}
				else{
					$typecont = '40';
				}

				$PB = abs($data['POIDS_DEU_PESEE'] - $data['POIDS_PRE_PESEE']);

				$this -> Cell(5,5,$i,$border,0,'C');
				$this -> Cell(20,5,dateFr($data['DATE_PESEE']),$border,0,'C');
				$this -> Cell(10,5,$typecont.'\'',$border,0,'C');
				$this -> Cell(20,5,$data['NUM_CONTENEUR'],$border,0,'C');
				$this -> Cell(30,5,str_replace(' ', '',$data['NUM_PLOMB']),$border,0,'C');
				$this -> SetFillColor(255,255,255);
				$this -> Cell(30,5,$site,$border,0,'C',1);
				$this -> Cell(18,5,number_format($PB, 0,',',' '),$border,0,'R',1);
				$this -> Cell(15,5,number_format($data['TARE_CONT'], 0,',',' '),$border,0,'R');
				$this -> Cell(12,5,number_format($data['TARE_EMB'], 0,',',' '),$border,0,'R');
				$this -> Cell(12,5,number_format($data['TARE_HAB'], 0,',',' '),$border,0,'R');
				$this -> Cell(18,5,number_format($data['POIDS_NET'], 0,',',' '),$border,0,'R');
				$this -> Ln();

				$i++;
				$somPb += $PB;
				$somTc += $data['TARE_CONT'];
				$somTb += $data['TARE_EMB'];
				$somTh += $data['TARE_HAB'];
				$somPn += $data['POIDS_NET'];
			}
			$query -> closeCursor();

			$this -> SetFont('Courier','B',10);
			$this -> SetFillColor(245,245,245);
			$this -> Cell(115,5,'TOTAL',$border,0,'C',1);
			$this -> SetFont('Courier','B',8);
			$this -> Cell(18,5,number_format($somPb, 0,',',' '),$border,0,'R');
			$this -> Cell(15,5,number_format($somTc, 0,',',' '),$border,0,'R');
			$this -> Cell(12,5,number_format($somTb, 0,',',' '),$border,0,'R');
			$this -> Cell(12,5,number_format($somTh, 0,',',' '),$border,0,'R');
			$this -> Cell(18,5,number_format($somPn, 0,',',' '),$border,0,'R');
			$this -> Ln();
		}

		function signature($nom,$pren,$fon,$tel){

			$this -> SetFont('Courier','',8);
			$this -> Cell(190,10,$nom.' '.$pren,0,0,'R');
			$this -> Ln(5);
			$this -> Cell(50,10,"Packing List".utf8_decode(" édité ")."le : ".date("d/m/Y").utf8_decode(" à ").date("H:i:s"),0,0,'L');
			$this -> Cell(140,10,$fon.' / '.$tel,0,0,'R');
		}
	}
?>
