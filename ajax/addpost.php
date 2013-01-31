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
		
		$pid = $db->insert_id;
		
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
		
		if(isset($mem))
		{
			$sql   = "SELECT * FROM users WHERE id='$uid'";
			$key    = md5('stanley'.$sql);
			$user  = $mem->get($key);
		
			if(!$user)
			{
			
				$half = $db->query($sql)->fetch_assoc();	
				$mem->set($key, $half, MEMCACHE_COMPRESSED, 864000);
				$user = $mem->get($key); 
			}	
		
		}
		
		if(strlen(@$user['img'])>0)	$pic = $user['img']; else $pic = 'gfx/faces/23.png';
		if(strlen(@$user['fname'])>0 && strlen($user['sname'])>0) $name = $user['fname'].' '.$user['sname']; else $name = $user['zhname'];
		
		$errors['stat'] = 'OK';
		$errors['pid']	= $pid;
		$errors['div']  = '';
	
	}else $errors['db'] = 1;	

}
else
{
	$errors['len'] = 1;
}

unest($pid, $sql);
echo json_encode($errors);


?>