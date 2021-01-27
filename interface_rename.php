<?php
$directory = './rename';
$gallery = scandir($directory);
// $gallery = preg_grep ('/\.png$/i', $gallery);
// $gallery = preg_grep ('/\.jpeg$/i', $gallery);
$gallery = preg_grep ('/\.png$/i', $gallery);
// print_r($gallery);

foreach ($gallery as $k2 => $v2) {
    if (exif_imagetype($directory."/".$v2) == IMAGETYPE_PNG OR exif_imagetype($directory."/".$v2) == IMAGETYPE_JPEG OR exif_imagetype($directory."/".$v2) == IMAGETYPE_SVG) {
        rename($directory.'/'.$v2, $directory.'/'.str_replace("’","'",$v2));
    }
}


?>
