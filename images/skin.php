<?php

function flip(&$img) {
    $size_x = imagesx($img);
    $size_y = imagesy($img);
    $temp = imagecreatetruecolor($size_x, $size_y);
    imagecopyresampled($temp, $img, 0, 0, ($size_x - 1), 0, $size_x, $size_y, 0 - $size_x, $size_y);
    return $temp;
}

header("Content-type: image/png");

$cacheFolder = 'cache';

$name = $_GET['name'];
$scale = isset($_GET['size']) && is_numeric($_GET['size']) ? intval($_GET['size']) : 1;

$cachePath = $cacheFolder . DIRECTORY_SEPARATOR . 'skin-' . $name . '-' . $scale . '.png';

if (is_file($cachePath)) {
    include($cachePath);
    exit();
}

$src = imagecreatefrompng("http://s3.amazonaws.com/MinecraftSkins/" . $name . ".png");

if (!$src) {
    $src = imagecreatefrompng("http://s3.amazonaws.com/MinecraftSkins/char.png");
}

$canvas = imagecreatetruecolor(16 * $scale, 32 * $scale);

imagealphablending($canvas, false);
imagesavealpha($canvas, true);
$transparent = imagecolorallocatealpha($canvas, 255, 255, 255, 127);
imagefilledrectangle($canvas, 0, 0, 16 * $scale, 32 * $scale, $transparent);

imagecopyresized($canvas, $src, 4 * $scale, 0 * $scale, 8, 8, 8 * $scale, 8 * $scale, 8, 8);  //head
imagecopyresized($canvas, $src, 4 * $scale, 8 * $scale, 20, 20, 8 * $scale, 12 * $scale, 8, 12); //body
imagecopyresized($canvas, $src, 0 * $scale, 8 * $scale, 44, 20, 4 * $scale, 12 * $scale, 4, 12); //arm left
imagecopyresampled($canvas, $src, 12 * $scale, 8 * $scale, 47, 20, 4 * $scale, 12 * $scale, -4, 12); //arm right (flipped)
imagecopyresized($canvas, $src, 4 * $scale, 20 * $scale, 4, 20, 4 * $scale, 12 * $scale, 4, 12); //leg left
imagecopyresampled($canvas, $src, 8 * $scale, 20 * $scale, 7, 20, 4 * $scale, 12 * $scale, -4, 12); //leg right (flipped)

imagepng($canvas, $cachePath);
readfile($cachePath);

imagedestroy($canvas);
imagedestroy($src);

