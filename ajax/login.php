<?php
session_start();
require_once('../libs/database.php');

$email   = strtolower($_POST['email']);
$passwd  = $_POST['passwd'];

$errors  = array();



if(empty($db)) $db = connect();



if($email && $passwd)
{

	$resp = $db->query("SELECT passwd, id FROM users WHERE email='$email' LIMIT 1");
	
	if($resp->num_rows == 1)
	{
		$tmp = $resp->fetch_assoc();
		
		$errors['email'] = 1;
		
		if(sha1($passwd) === $tmp['passwd'])
		{ 
			
			/*
			some small security updates - check IP address			
			*/
			
			if(!empty($_SERVER['HTTP_CLIENT_IP'])){$ip=$_SERVER['HTTP_CLIENT_IP'];	
			}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];} else {$ip=$_SERVER['REMOTE_ADDR'];}
			
			/*
			
			*/

			$errors['stat']    = 'OK';
				
			$errors['passwd']  = 1;
			$errors['email']   = 1;
			
			$_SESSION['id'] = $tmp['id'];
			unset($resp, $tmp);
		
		}else $errors['passwd'] = 0;		
			
	}else
	{
		$errors['passwd'] = 0;
		$errors['email']  = 0;
	}

}
else
{
		$errors['passwd'] = 0;
		$errors['email']  = 0;
}

echo json_encode($errors);