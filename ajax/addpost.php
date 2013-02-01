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
		
		if(isset($mem))
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
				$sql = "SELECT * FROM posts ORDER BY date DESC";
				$mem->delete(md5('stanley'.$sql));
			}
		

			$sql   = "SELECT * FROM users WHERE id='$uid' LIMIT 1";
			$key   = md5('stanley'.$sql);
			$user  = $mem->get($key);
		
			if(!$user)
			{
			
				$half = $db->query($sql)->fetch_assoc();	
				$mem->set($key, $half, MEMCACHE_COMPRESSED, 864000);
				$user = $mem->get($key); 
			}	
		
		}else $errors['mem'] = 1;
		
		if(strlen(@$user['img'])>0)	$pic = $user['img']; else $pic = 'gfx/faces/23.png';
		if(strlen(@$user['fname'])>0 && strlen($user['sname'])>0) $name = $user['fname'].' '.$user['sname']; else $name = $user['zhname'];
		
		
		$tmp = $db->query("SELECT * FROM categories WHERE id='$cat' LIMIT 1")->fetch_assoc();
		
		$errors['stat'] = 'OK';
		$errors['pid']	= $pid;
		$errors['div']  = '<div class="post" id="post'.$pid.'">
								<table celpadding="0" cellspacing="0">
									<tr>
										<td><img src="'.$pic.'"  width="30" height="30" /></td>
										<td style="width:550px; text-align: left;">'.$name.'</td>
										<td><a href="#" onclick="deletePost('.$pid.','.$cat.')"><img src="gfx/x.gif" /></a></td>
									</tr>
									<tr>
										<td valign="top"><div style="background:'.$tmp['color'].';, width: 30px; height: 30px; color: white; font-size: 23px; text-align: center;">'.substr(ucfirst($tmp['name']),0, 1).'</div></td>
										<td colspan="2" class="postBody">'.$body.'<br /><br /></td>
									</tr>
									<tr>
										<td valign="top" align="center"><img src="gfx/comment.png" /></td>
										<td colspan="2">

												<table celpadding="0" cellspacing="0">
												<tr>
													<td colspan="2">
													<div id="newComment'.$pid.'"></id>
													</td>
												</tr>		
												<tr>
													<td><img src="'.$pic.'" width="25" height="25" /></td>
													<td><input type="text" id="commentBody'.$pid.'" name="commentBody'.$pid.'" class="commentBody" onkeypress="return addcomment(event, '.$pid.')" /></td>
												</tr>
												</table>

										</td>
									</tr>		
								</table>
							  </div><br />';
	
		unset($tmp, $user, $sql, $key);
		
	}else $errors['db'] = 1;	

}
else
{
	$errors['len'] = 1;
}

echo json_encode($errors);


?>