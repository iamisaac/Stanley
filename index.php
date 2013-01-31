<?php 
session_start();

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 'on');

/*


*/
require_once('libs/config.php');
require_once('libs/database.php');
require_once('libs/modules.php');
require_once('libs/lang.php');



/*
Facebook, Twitter, Instagram
*/

require_once('libs/ext/facebook/facebook.php');

if(class_exists('Facebook'))
{


		$fb = new Facebook(array(
		  'appId'  => fbid,
		  'secret' => fbsec,
		));
	
		$user   = $fb->getUser();
		$fblog  = $fb->getLoginUrl(
            array(
                'scope'         => 'email,user_religion_politics,offline_access,publish_stream,user_birthday,
                					user_location,user_work_history,user_about_me,user_hometown,user_likes,user_interests',
                'redirect_uri'  => 'http://shen.jointheway.com/'
            ));
		
		if ($user) 
		{
		  	try
		  	{
		  
		    	$user_profile = $fb->api('/me');
		  
		  	} catch (FacebookApiException $e) 
		  	{
		  
		  	}
		}

}
/*
GET area -> everything what is needed is better to take right now
*/

if(isset($_GET['w'])) $what = $_GET['w']; else $what = 'start';


/*


*/

global $layout;
global $db;
global $user;
global $posts;
global $lang;
	
if(class_exists('Memcache'))
{	

	global $mem;
	$mem = new Memcache;
	$mem->addServer('localhost', 11211);
	$mem->connect('localhost', 11211);

}
else
{

	echo 'Need memcache to run';
	exit;

}


$db         	= connect();
$user      		= null;
$posts 			= null;
$lang       	= setLanguage();
$layout     	= new layout();
$layout->appid	= $fb->getAppID();
$layout->db 	= $db;



/*
choose language version 
*/


if(isset($_SESSION['id']))
{
	/*
	inside the webpage ... only registered users
	*/
	
	$id = $_SESSION['id'];
	
	if($what)
	{
	
		$user = $db->query("SELECT * FROM users WHERE id='$id' LIMIT 1")->fetch_assoc();
			
		switch($what)
		{
			case 'start':
			{	
				$layout->up();
				require('layouts/start.php');								
				break;
			}
			case 'profile':
			{
				$layout->up();
				require('layouts/profile.php');
				break;
			}
			case 'messages':
			{
				$layout->up();
				require('layouts/messages.php');
				break;
			}
			case 'admim':
			{
				$layout->up();
				require('layouts/admin.php');
				break;
			}
			default:
			{
				$layout->up();
				require('layouts/start.php');								
				break;
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
	$layout->up('Enter!');
	require('layouts/enter.php');
	$layout->down();
}	
	


?>
