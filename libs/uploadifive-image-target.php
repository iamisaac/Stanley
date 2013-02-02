<?php
session_start();

require_once('database.php');
require_once('config.php');
require_once('ext/imagemap/WideImage.php');
require_once('ext/cloudfiles/cloudfiles.php');

function createRandomPassword() {
    $chars = "abcdefghijkmnopqrstuvwxyz0123456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;
    while ($i < 30) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
}

$target = $_GET['target'];

if(empty($db))   $db         = connect();
                 $imgmap     =  new WideImage();
                 $id         =  $_SESSION['$id'];
				 $login      =  $id;

function errorHandler($errno, $errstr, $errfile, $errline) {return true;}
$old_error_handler = set_error_handler("errorHandler");

$array   = array('start', 'profile', 'messages', 'admin', 'files');
$output  = array();


if(in_array($target, $array))
{

    if($target == 'files')
    {
		/*
		
		*/




    }
    else
    {

        // Check if the file has a width and height
        $uploadDir = '../users/'.$login.'/';


        // Check if the file has a width and height
        function isImage($tempFile) {

            // Get the size of the image
            $size = getimagesize($tempFile);

            if (isset($size) && $size[0] && $size[1] && $size[0] *  $size[1] > 0) {
                return true;
            } else {
                return false;
            }

        }

        if (!empty($_FILES)) {

            $fileData = $_FILES['Filedata'];

            if ($fileData) {

                $tempFile   = $fileData['tmp_name'];

                $fn                   = strtolower($fileData['name']);
                $fn                   = preg_replace('/[^\w\._]+/', '', $fn);
                list($fileName, $ext) = explode('.', $fn);
                $fileName             = substr(createRandomPassword(), 0, 23);
                $fn                   = $fileName.'.'.$ext;
                $targetFile           = $uploadDir . $fn;
                $error                = 0;

                if(!is_dir('../users/'.$login)) mkdir('../users/'.$login);

                // Validate the file type
                $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG'); // Allowed file extensions
                $fileParts = pathinfo($fileData['name']);

                // Validate the filetype
                if (in_array(strtolower($fileParts['extension']), $fileTypes) && filesize($tempFile) > 0 && isImage($tempFile)) {

                    // Save the file
                    if(move_uploaded_file($tempFile, $targetFile))
                    {
                        list($szer, $wys) = getimagesize($targetFile);

                        if($szer>90 && $wys>90)
                        {
                            if($szer>$wys) $wspol=$wys/90; else $wspol=$szer/90;

                            $nszer=round($szer/$wspol, 0);
                            $nwys=round($wys/$wspol, 0);

                            $imgmap->load($targetFile)->resize($nszer, $nwys)->crop("center", "middle", 90, 90)->saveToFile($uploadDir.'_cube_'.$fn);
                        }
                        else
                        {
                            copy($targetFile, $uploadDir.'_cube_'.$fn);
                        }
                        if(($szer>125 && $wys>125) || ($szer>125 && $wys<125) || ($szer<125 && $wys>125))
                        {
                            if($szer>$wys) $wspol=$szer/125; else $wspol=$wys/125;

                            $nszer=round($szer/$wspol, 0);
                            $nwys=round($wys/$wspol, 0);

                            $imgmap->load($targetFile)->resize($nszer,$nwys)->saveToFile($uploadDir.'_mini_'.$fn);
                        }
                        else
                        {
                            copy($targetFile, $uploadDir.'_mini_'.$fn);
                        }

                        if(($szer>760 && $wys>760) || ($szer>760 && $wys<760) || ($szer<760 && $wys>760))
                        {
                            if($szer>$wys) $wspol=$szer/760; else $wspol=$wys/760;

                            $nszer=round($szer/$wspol, 0);
                            $nwys=round($wys/$wspol, 0);

                            $imgmap->load($targetFile)->resize($nszer,$nwys)->saveToFile($uploadDir.'_optim_'.$fn);
                        }
                        else
                        {
                            copy($targetFile, $uploadDir.'_optim_'.$fn);
                        }

                        $username = cluser;
                        $key      = clkey;

                        @$auth = new CF_Authentication($username, $key);
                        @$auth->authenticate();
                        @$conn = new CF_Connection($auth);

                        @$container = $conn->get_container(clcon);


                        if(file_exists($uploadDir.$fn))
                        {
                            $object = $container->create_object($target.'/'.$fn);
                            $object->load_from_filename($uploadDir.$fn); unset($object);
                            unlink($uploadDir.$fn);

                        }else $error = 1;
                        //upload optim
                        if(file_exists($uploadDir.'_optim_'.$fn))
                        {
                            $object = $container->create_object($target.'/_optim_'.$fn);
                            $object->load_from_filename($uploadDir.'_optim_'.$fn); unset($object);
                            unlink($uploadDir.'_optim_'.$fn);
                        }else $error = 1;
                        //upload mini
                        if(file_exists($uploadDir.'_mini_'.$fn))
                        {
                            $object = $container->create_object($target.'/_mini_'.$fn);
                            $object->load_from_filename($uploadDir.'_mini_'.$fn); unset($object);
                            unlink($uploadDir.'_mini_'.$fn);
                        }else $error = 1;
                        //upload cube
                        if(file_exists($uploadDir.'_cube_'.$fn))
                        {
                            $object = $container->create_object($target.'/_cube_'.$fn);
                            $object->load_from_filename($uploadDir.'_cube_'.$fn); unset($object);
                            unlink($uploadDir.'_cube_'.$fn);
                        }else $error = 1;

                        if($error == 0)
                        {

                            $url  =  str_replace(' ', '','https://baa4734103bafcc1e1a0-1e54df3c7b80492f9c27542cf6bc48c3.ssl.cf2.rackcdn.com/'.$target.'/_cube_'.$fn);
							$url2 =  str_replace(' ', '','https://baa4734103bafcc1e1a0-1e54df3c7b80492f9c27542cf6bc48c3.ssl.cf2.rackcdn.com/'.$target.'/'.$fn);
                            $db->query("INSERT INTO images SET uid='$id', target='$target', link='$url2', linkCube='$url'");

                            $output['id']     = $db->insert_id;
                            $output['url']    = $url;
                            $output['target'] = $target;

                            $json = json_encode($output);

                            if(empty($_SESSION['tmpArray']))
                            {
                                $_SESSION['tmpArray'][0] = $output;
                            }
                            else
                            {
                                $tmpArray = $_SESSION['tmpArray'];
                                array_push($tmpArray, $output);
                                $_SESSION['tmpArray'] = $tmpArray;
                            }


                            echo $json;
                        }

						unset($url, $url2, $output, $object, $imgmap);
                    }

                } else {

                    // The file type wasn't allowed
                    echo 'Invalid file type.';
                }
            }
        }
    }
}

?>