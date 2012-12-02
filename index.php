<?php
session_start();

require_once('libs/modules.php');


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
	$layout->title = '';
	$layout->up();
	
	require 'layouts/enter.php';
	
	$layout->down();
}	
	




?>
under construction