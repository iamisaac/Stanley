<?php
session_start();

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 'on');

/*


*/
require_once('libs/modules.php');
require_once('libs/config.php');


global $layout;

$layout = new layout();



if(isset($_SESSION['login']))
{
	/*
	inside the webpage ... only registered users
	*/
	
	$layout->up();
	
	switch($what)
	{
		case '':
		{
			
			
			
			
			break;
		}
		default:
		{
			break;
		}
	}
	
	
	
	

}else
{
	/*
	login page
	*/
	$layout->title = 'Please first login!';
	$layout->up();
	
	require 'layouts/enter.php';
	
	$layout->down();
}	
	




?>
