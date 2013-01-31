<?php
session_start();

require_once('../libs/database.php');

$pid  = $_POST['pid'];
$body = $_POST['body'];

$errors = array();

if(empty($db)) $db = connect();
if(empty($mem))
{
	$mem = new Memcache;
	$mem->addServer('localhost', 11211);
	$mem->connect('localhost', 11211);
}

if(strlen($body)>0 && strlen($body)<4096)
{
	
	$body = htmlspecialchars($body);
	$uid  = $_SESSION['id'];
	
	if($db->query("INSERT INTO comments SET uid='$uid', pid='$pid', body='$body'"))		
	{
		
		$cid = $db->inserd_id;
		$errors['stat'] = 'OK';
	}
	
	
}else
{
	$errors['len'] = 1;
}	
	
	
unset($id);	
echo json_encode($errors);


?>