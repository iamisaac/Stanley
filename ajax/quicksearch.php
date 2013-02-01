<?php
session_start();
require_once('../libs/database.php');

$q = $_POST['q'];
	
$errors = array();

if(empty($db)) $db = connect();


$errors['stat'] = 'OK';

$errors['div']  = 'asdjfhasljdhfasdfasd';


	
echo json_encode($errors);	
?>