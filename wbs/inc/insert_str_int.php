<?php


function insert_int($val)
	{
	$val=str_replace(" ","",$val);	
	return (!ctype_digit($val)?0:$val);
	}

function insert_str($val)
	{
	return str_replace("\\","",str_replace("'","''",$val));
	}

?>
