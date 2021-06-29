<?php

function Post($url,$token,$pass)
        {
	$content = array('token' => $token, 'passwd' => $pass);
        $requete = array(  'http' =>   array( 'method'  => 'POST', 'header'  => 'Content-type: application/x-www-form-urlencoded',  'content' => http_build_query($content) ) );
        $context = stream_context_create($requete);
        $content = @file_get_contents($url, false, $context);

        return $content;
        }

function Get($url,$token,$pass)
        {
        $content = @file_get_contents($url."?token=".$token."&pass=".$pass);

        return $content;
        }


?>
