<?php
if(strlen(@$user['img'])>0)	$pic = $user['img']; else $pic = 'gfx/faces/23.png';
if(strlen(@$user['fname'])>0 && strlen($user['sname'])>0) $name = $user['fname'].' '.$user['sname']; else $name = $user['zhname'];

$layout->name  = $name;
$layout->pic   = $pic;

$layout->baner();

?>
<link href="css/ext/checkbox.css" rel="stylesheet" type="text/css" />
<div class="mainArea native margin">
	<div class="inside">	
		<div class="sp1">
			<ul>
                <li><a href="" class="big">General</a></li>
                <li><a href="" class="big">Privacy</a></li>
			</ul>
		</div>
		<div class="sp2">
            <img src="<?php echo $pic; ?>" width="90" height="90" />
		    <div id="profileArea">



		    </div>
        </div>
		<div class="sp3">
			
		</div>	
	</div>
</div>
