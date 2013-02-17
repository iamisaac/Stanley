<?php
session_start();
require_once('../libs/database.php');

$q    = $_POST['q'];
$spec = $_POST['spec'];	

$errors   = array();
$research = array();
$sql	  = null;

if(empty($db)) $db = connect();

/*

let's see what is going to be done

*/

function posts($what, $limit, $db)
{
	$ask = $db->query("SELECT * FROM posts WHERE body LIKE '%$what%' ORDER BY RAND() LIMIT $limit");
	return $ask->fetch_assoc();
}

function comments($what, $limit, $db)
{
	$ask = $db->query("SELECT * FROM posts WHERE body LIKE '%$what%' ORDER BY RAND() LIMIT $limit");
	return $ask->fetch_assoc();
}

function users($what, $limit, $db)
{

    $ask = $db->query("SELECT * FROM users WHERE (sname LIKE '%$what%' OR fname LIKE '%$what%' OR zhname LIKE '%$what%') ORDER BY RAND() LIMIT $limit");
    return $ask->fetch_assoc();
}


if($spec == '')
{
	
	
	
}
else
{
	
	list($research) = explode(' ', $q);
	
	if(count($research) <= 2)
	{
		
		
				
	}
	
}

/*
preparing results
*/





unset($ask);
echo json_encode($errors);
?>