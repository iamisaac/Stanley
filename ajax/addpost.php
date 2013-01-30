<?php
session_start();

require_once('../libs/database.php');

$body   = $_POST['body'];
$cat	= $_POST['cat'];

$errors = array();

if(empty($db)) $db = connect();

if(empty($mem))
{

	$mem = new Memcache;
	$mem->addServer('localhost', 11211);
	$mem->connect('localhost', 11211);

}


if(strlen($body)<4096 && strlen($body)>3)
{
	
	$body = htmlspecialchars($body);
	$uid  = $_SESSION['id'];
	
	if($db->query("INSERT INTO posts SET uid='$uid', body='$body', cat='$cat'"))
	{
		
		$id = $db->insert_id;
		
		if($cat==1)
		{
			$sql = "SELECT * FROM posts ORDER BY date DESC";
			$mem->delete(md5('stanley'.$sql));
		}
		else
		{
			$sql = "SELECT * FROM posts WHERE cat='$cat' ORDER BY date DESC"; 
			$mem->delete(md5('stanley'.$sql));
		}
		
		$errors['stat'] = 'OK';	
	
	}else $errors['db'] = 1;	

}
else
{
	$errors['len'] = 1;
}

unest($id, $sql);
echo json_encode($errors);


?>