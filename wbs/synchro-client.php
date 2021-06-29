<?php
include_once('inc/config_client.php');
include_once('inc/logger_client.php');
$url="http://197.159.208.198/alert-synchro/synchro-server.php";
$serverid=4; //0-SOLAS 1-BACKUP 2-IPAGE 3-NSIA 4-LOGIC  //1-SOLAS 2-NSIA 3-IPAGE 4-BACKUP 5-LOGIC
$adresse="127.0.0.1";
$user="root";
$pass=array("","","","",""); 

$lastid=-1;

if(($dblink = connecterBD($adresse,$user,$pass[$serverid],"solas"))!==false){
	$result = mysql_query("SELECT MAX(`IDENTIFIANT`) AS ID FROM `TICKET`");
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		$lastid=$row['ID'];

//	Loger("synchro-client: "."LOCAL SOLAS DB ID=>".$lastid);

	mysql_close($dblink);
}else{
//	Loger("synchro-client: "."LOCAL SOLAS DB =>ko");
}

if(GetURL($url,$serverid,$lastid)!==false){
//	Loger("synchro-client: "."REMOTE SOLAS SERVER=>ok");
}else{
//	Loger("synchro-client: "."REMOTE SOLAS SERVER=>ko");
}


function ConnecterBD($ip,$usr,$pwd,$db){

	@ $link = mysql_connect($ip, $usr, $pwd);
	@ mysql_select_db($db,$link);
	return $link;
}	

function GetURL($url,$serverid,$lastid){

        @ $content = file_get_contents($url."?serverid=".$serverid."&lastid=".$lastid);
       return $content;
}


?>
