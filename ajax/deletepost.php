<?php
session_start();

require_once('../libs/database.php');

$pid  = $_POST['pid'];
$cat  = $_POST['cat'];

$errors = array();

if(empty($db)) $db = connect();
if(empty($mem))
{
	$mem = new Memcache;
	$mem->addServer('localhost', 11211);
	$mem->connect('localhost', 11211);
}

if($db->query("DELETE FROM posts WHERE id='$pid'"))
{
	
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
	
	if($db->query("DELETE FROM comments WHERE pid='$pid'"))
	{
		$sql = "SELECT * FROM comments WHERE pid='$pid' ORDER BY date";
		$mem->delete(md5('stanley'.$sql));
		
		$errors['stat'] = 'OK';
	}
}


echo json_encode($errors);
?>