<?php

class layout
{
	
	public $db;
	public $name;
	public $pic;
	public $appid;
	
	public function up($title = '...')
	{
		
		echo
		
		'
		<!DOCTYPE html>
		<html>
		<head>
		<title>'.$title.'</title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		
		<link href="css/main.css" rel="stylesheet" type="text/css" />
		<link href="css/ext/tipped/tipped.css" rel="stylesheet" type="text/css" />
		<link href="css/ext/lighview/lighview.css" rel="stylesheet" type="text/css" />
		
		<script type="text/javascript" src="js/jq190.js"></script>
		
		</head>
		<body>
		<div id="main">
		';
				
		
		
	}

	public function down()
	{
		
		echo
		'
		</div>
		<div id="fb-root"></div>
		<script>
		  window.fbAsyncInit = function() {
		    FB.init({
		      appId:'.$this->appid.',
		      cookie: true,
		      xfbml: true,
		      oauth: true
		    });
		    FB.Event.subscribe(\'auth.login\', function(response) {
		      window.location.reload();
		    });
		  };
		  (function() {
		    var e = document.createElement(\'script\'); e.async = true;
		    e.src = document.location.protocol +
		      "//connect.facebook.net/en_US/all.js";
		    document.getElementById(\'fb-root\').appendChild(e);
		  }());
		</script>
		<!--[if lt IE 9]>
			<script type="text/javascript" src="js/ext/excanvas/excanvas.js"></script>
		<![endif]-->
		<script type="text/javascript" src="js/ext/spinners/spinners.min.js"></script>
		<script type="text/javascript" src="js/ext/lightview/lightview.js"></script>
		<script type="text/javascript" src="js/ext/tipped/tipped.js"></script>
		<script type="text/javascript" src="js/main.js"></script>
		<script type="text/javascript" src="js/ext/colorbox.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function($) { $(\'.tipped\').each(function(){ Tipped.create(this); }); });
		</script>
		<div id="overlayBody"><div id="ovInside"></div></div>
		<div id="searchArea">
			<div class="menu">
				<div id="inputText"></div>
				<div id="searchBody" class="searchBody"></div>
			<div>		
		</div>
		</body>
		</html>';
		
	}
	
	public function baner()
	{
		
		echo '
		<div class="topBaner">
		<div class="menu">
			<table>
				<tr>
					<td><a href="?w=profile"><img src="'.$this->pic.'" width="35" height="35" border="0" /></a></td>
					<td style="width: 263px;"><span class="upName">'.$this->name.'</span></td>
					<td style="width: 600px;">
						<input id="search" name="search" class="search"></input>
					</td>				
					<td style="text-align: right; width: 70px;"><a href="#"><img id="logout" class="tipped" title="Exit" src="gfx/poweroff.gif" width="20" height="20" border="0" /></a></td>
				</tr>
			</table>	
		</div>
		</div>';
	}
	
	public function categories()
	{
		
		
	}	
}