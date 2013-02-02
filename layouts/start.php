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
			echo '<ul style="list-style: none; margin: 0px";>
			      <li><div class="box"></div><a class="big" href="?cat=0">ALL</a></li>';

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

<script type="text/javascript">
$(function() {
    $('#file_upload').uploadifive({
        'auto'         : true,
        'simUploadLimit' : 1,
        'fileSizeLimit' : '4096KB',
        'uploadLimit' : 4,
        'queueID'      : 'queue',
        'uploadScript' : '../libs/uploadifive-image-target.php?target=<?php echo $what; ?>',
        'onUploadComplete' : function(file, res)
        {
            var obj = jQuery.parseJSON(res);

            alert(res);

            if(typeof obj == 'object')
            {
                if(obj.stat == 'OK')
                {
                    $('#preview').append('<img src="'+obj.url+'" width="40" height="40"  /> ');
                }
            }
        }       
     });
});
</script>

<script type="text/javascript" src="https://www.dropbox.com/static/api/1/dropbox.js" id="dropboxjs" data-app-key="<?php echo dbchooser; ?>"></script>
<script type="text/javascript" src="js/posts.js"></script>
