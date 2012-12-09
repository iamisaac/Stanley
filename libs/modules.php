<?php

class layout
{
	
	public $title;
	public $db;
	
	public function up()
	{
		
		echo
		
		'
		<!DOCTYPE html>
		<html>
		<head>
		<title>'.$this->title.'</title>
		<link href="css/main.css" rel="stylesheet" type="text/css" />
		
		<script type="text/javascript" src="js/jq183.js"></script>
		</head>
		<body>
		<div id="main">';
		
		
	}

	public function down()
	{
		
		echo
		'
		</div>
		<script type="text/javascript" src="js/main.js"></script>
		</body>
		</html>';
		
	}
}