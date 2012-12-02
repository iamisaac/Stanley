<?php

class layout
{
	
	public $title;
	
	public function up()
	{
		
		echo
		
		'<html>
		<head>
		<title>'.$title.'</title>
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