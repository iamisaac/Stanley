<?php
require_once('libs/posts.php');

if(isset($_GET['cat'])) $cat = $_GET['cat']; else $cat = 0;

$posts      = new posts();
$posts->db  = $db;
$posts->mem = $mem;
						
if(strlen(@$user['img'])>0)	$pic = $user['img']; else $pic = 'gfx/faces/23.png';
if(strlen(@$user['fname'])>0 && strlen($user['sname'])>0) $name = $user['fname'].' '.$user['sname']; else $name = $user['zhname'];

$layout->name  = $name;
$layout->pic   = $pic;

$layout->baner();

?>
<div class="mainArea native margin">
	<div class="inside">	
		<div class="sp1">

		<?php
			echo '<ul style="list-style: none; margin: 0px";>';
			$resp = $db->query("SELECT * FROM categories");
			while($tmp = $resp->fetch_assoc())
			{
				echo '<li><div class="box" style="background:'.$tmp['color'].'"></div><a href="?cat='.$tmp['id'].'" class="big">'.ucfirst($tmp['name']).'</a></li>';
				if($tmp['id'] == $cat) $posts->cat = $cat;
			}
			echo '</ul>';
			
			unset($resp, $tmp);
		?>
		</div>
		<div class="sp2">
			<div id="startMainArea">		
			<?php 
				
									
				$posts->name  = $name;
				$posts->pic   = $pic;
				$posts->mem   = $mem;
				$posts->db    = $db;		
				$posts->create();
				
			?>
			</div>	
		</div>
		<div class="sp3">

		</div>	
	</div>
</div>
<script type="text/javascript" src="https://www.dropbox.com/static/api/1/dropbox.js" id="dropboxjs" data-app-key="<?php echo dbchooser; ?>"></script>