<?php

class layout
{
	
	public $title;
	
	public function up()
	{
		
		echo
		
		'<html>
		<head>
		<title>'.$this->title.'</title>
		<link href="css/main.css" rel="stylesheet" type="text/css" />
		</head>
		<body>
		<div id="main">';
		
		
	}

	public function down()
	{
		
		echo
		'
		</div>
		</body>
		</html>';
		
	}
}