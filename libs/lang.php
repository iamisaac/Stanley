<?php

function setLanguage()
{

	if(!empty($_SERVER['HTTP_CLIENT_IP'])){$ip=$_SERVER['HTTP_CLIENT_IP'];}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];} else { $ip=$_SERVER['REMOTE_ADDR']; }
	
	$response=@file_get_contents('http://www.netip.de/search?query='.$ip);	 
		
		$patterns=array(); 
		$patterns["domain"] = '#Domain: (.*?)&nbsp;#i'; 
		$patterns["country"] = '#Country: (.*?)&nbsp;#i'; 
		$patterns["state"] = '#State/Region: (.*?)<br#i'; 
		$patterns["town"] = '#City: (.*?)<br#i'; 
		
		$ipInfo=array();
	 
	foreach ($patterns as $key => $pattern){ $ipInfo[$key] = preg_match($pattern,$response,$value) && !empty($value[1]) ? $value[1] : 'not found'; }
	 
	$code = substr($ipInfo["country"], 0, 3);

	switch ($code)
    {
        case 'en':
        {

            break;
        }
        case 'tw':
        {

            break;
        }
        case 'zh':
        {

            break;
        }
        default:
        {

            break;
        }
    }
	
	unset($ipInfo);
}

?>