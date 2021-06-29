<?php
	
	$serv="localhost";
	$user="root";
	$pswd="";
	$base="logic";
	$bdd = new PDO('mysql:host='.$serv.';dbname='.$base.';charset=utf8', $user, $pswd,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

	date_default_timezone_set("Africa/Abidjan");

	$pass='IYEvgdjqaP6Ni63E8bmpkj2jYSe5878uL2';

	$link="https://198.1.107.9/web_services/packinglist/";
	$path="C:\\wamp\\www\\logic\\wbs\\tmp\\";
	$log="C:\\wamp\\www\\logic\\wbs\\tmp\\logic.log";
	$rep_logo ="C:\\wamp\\www\\logic\\";

	$delay_get_new_pcklist=0;
	$cntrl_get_new_pcklist=$path."cntrl_new_pcklist.db";
	$url_get_new_pcklist =$link."send_new_pcklist.php"; 
	$last_token_get_new_pcklist=$path."last_token_new_pcklist.db";

	$delay_get_pcklist_update=0;
	$cntrl_get_pcklist_update=$path."cntrl_pcklist_update.db";
	$url_get_pcklist_update = $link."send_pcklist_update.php"; 
	$last_token_get_pcklist_update=$path."last_token_pcklist_update.db";

	$delay_send_certif_update=0;
	$cntrl_certif_update =$path."cntrl_certif_update.db"; 
	$url_send_certif_update =$link."get_certif_update.php"; 
	$max_lign_send_certif_update=10;

	$delay_get_param_table=0;
	$cntrl_get_param_table=$path."cntrl_get_param_tables.db";
	$url_get_param_table = $link."send_param_tables.php"; 
	$last_token_get_param_table=$path."last_token_param_tables.db";

	$delay_send_param_table=0;
	$cntrl_send_param_table = $path."cntrl_send_param_table.db"; 
	$url_send_param_table = $link."get_param_table.php"; 
	$max_lign_send_param_table=10;

	$delay_send_logo_ftp=0;
	$cntrl_send_logo = $path."cntrl_send_logo_ftp.db"; 
	$ip_send_send_logo_ftp = "198.1.107.9"; 
	$user_send_send_logo_ftp = "vgmci"; 
	$pass_send_send_logo_ftp = "Disc*001"; 
	$rep_send_logo_ftp = "pcklist_logo"; 

	$delay_dispatch_matching=0;
	$cntrl_dispatch_matching=$path."cntrl_dispatch_matching.db";

	$delay_send_certif_auth = 0;
	$cntrl_certif_auth = $path."cntrl_certif_auth.db"; 
	$url_send_certif_auth = $link."get_certif_auth.php";

	$cntrl_resynchro = $path."cntrl_resynchro.db"; 
	$delay_resynchro=0;
	$ip_resynchro = "197.159.208.198"; 
	$user_resynchro = "solas"; 
	$pass_resynchro = "cciserver4solas"; 
	$rep_resynchro = "BDSOLAS/RESYNCHRO/"; 

?>