<?php
if(strlen(@$user['img'])>0)	$pic = $user['img']; else $pic = 'gfx/faces/23.png';
if(strlen(@$user['fname'])>0 && strlen($user['sname'])>0) $name = $user['fname'].' '.$user['sname']; else $name = $user['zhname'];

$layout->name  = $name;
$layout->pic   = $pic;

$layout->baner();

/*
 *
 */
if(isset($_GET['in'])) $in = $_GET['in']; else $in = 'general';

?>
<link href="css/ext/checkbox.css" rel="stylesheet" type="text/css" />
<div class="mainArea native margin">
	<div class="inside">	
		<div class="sp1">
			<ul style="list-style: none;">
                <li><a href="?w=profile&in=general" class="big">General</a></li>
                <li><a href="?w=profile&in=privacy" class="big">Privacy</a></li>
                <li><a href="?w=profile&in=stat" class="big">Statistics</a></li>
                <li><a href="?w=profile&in=public"class="big"><br />Public profile</a></li>
			</ul>
		</div>
		<div class="sp2">
            <img src="<?php echo $pic; ?>" width="90" height="90" />
		    <div id="profileArea">
                <?php
                    switch($in)
                    {
                        case 'general':
                        {
                            require 'in/profile/general.php';
                            break;
                        }
                        case 'privacy':
                        {
                            require 'in/profile/privacy.php';
                            break;
                        }
                        default:
                        {

                            break;
                        }
                    }

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
            'simUploadLimit' : 1,
            'fileSizeLimit' : '4096KB',
            'uploadLimit' : 6,
            'queueID'      : 'queue',
            'uploadScript' : '../libs/uploadifive-image-target.php?target=<?php echo $what; ?>',
            'onDrop'       : function(file, fileDropCount) {},
            'onUploadComplete' : function(file, res)
            {
                var obj = jQuery.parseJSON(res);

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