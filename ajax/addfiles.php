<?php
session_start();

require_once('../libs/database.php');

if(empty($db)) $db = connect();

$files = $_POST['files'];

$added = array();
$uid   = $_SESSION['id'];

if(count($files)>0)
{
    for($i=0;$i<count($files);$i++)
    {
        $file_name     = $files[$i]['name'];
        $file_link     = $files[$i]['link'];
        $file_bytes    = $files[$i]['bytes'];
        $file_icon     = $files[$i]['icon'];
        $file_thumb64  = $files[$i]['thumbnails']['64x64'];
        $file_thumb200 = $files[$i]['thumbnails']['200x200'];

        $db->query("INSERT INTO DBFiles SET uid='$uid', name='$file_name', link='$file_link',
                    bytes='$file_bytes', thumb64='$file_thumb64', thumb200='$file_thumb200'");

        $id = $db->insert_id;

        $_SESSION['dropboxAdded'][$i] = $id;

    }
}

unset($files, $added, $file_name, $file_link, $file_bytes, $file_thumb64, $file_thumb200);

?>