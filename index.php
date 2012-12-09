<?php 
session_start();

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 'on');

/*


*/
require_once('libs/database.php');
require_once('libs/modules.php');

/*

*/

if(isset($_GET['w'])) $what = $_GET['w'];

/*


*/

global $layout;
global $db;

$db         = connect();
$layout     = new layout();
$layout->db = $db;




if(isset($_SESSION['login']))
{
	/*
	inside the webpage ... only registered users
	*/
	
	$layout->up();
	
	
	if($what)
	{
		
		$layout->up();
		
		switch($what)
		{
			case 'start':
			{
				require('layouts/start.php');								
				break;
			}
			case 'profile':
			{
				require('layouts/profile.php');
			}
			default:
			{
				break;
			}
		}

		$layout->down();
	
	}else	
	{
		
	}
	
	

}else
{
	/*
	login page
	*/
	$layout->title = 'Enter!';
	$layout->up();
	
	require('layouts/enter.php');
	
	$layout->down();
}	
	




?>
