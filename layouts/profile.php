<?php
if(strlen(@$user['img'])>0)	$pic = $user['img']; else $pic = 'gfx/faces/23.png';
if(strlen(@$user['fname'])>0 && strlen($user['sname'])>0) $name = $user['fname'].' '.$user['sname']; else $name = $user['zhname'];

$layout->name  = $name;
$layout->pic   = $pic;

$layout->baner();

?>
<div class="mainArea native margin">
	<div class="inside">	
		<div class="sp1">
			
		</div>
		<div class="sp2">
			
			
			
		</div>
		<div class="sp3">
			
		</div>	
	</div>
</div>
