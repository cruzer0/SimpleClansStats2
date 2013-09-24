<?php

header("Content-type: image/png");

$cacheFolder = 'cache';

$name = $_GET['name'];
$size = isset($_GET['size']) && is_numeric($_GET['size']) ? intval($_GET['size']) : 16;

$cachePath = $cacheFolder . DIRECTORY_SEPARATOR . 'avatar-' . $name . '-' . $size . '.png';

if (is_file($cachePath)) {
    include($cachePath);
    exit();
}

$src = imagecreatefrompng("http://s3.amazonaws.com/MinecraftSkins/" . $name . ".png");

if (!$src) {
    $src = imagecreatefrompng("http://s3.amazonaws.com/MinecraftSkins/char.png");
}

$dest = imagecreatetruecolor(8, 8);
imagecopy($dest, $src, 0, 0, 8, 8, 8, 8);

$final = imagecreatetruecolor($size, $size);
imagecopyresized($final, $dest, 0, 0, 0, 0, $size, $size, 8, 8);

imagepng($final, $cachePath);
readfile($cachePath);

imagedestroy($dest);
imagedestroy($final);
?>