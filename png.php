<?php
// error_reporting(E_ALL);

$font = __DIR__.'/GOTHIC.TTF';
$width = 800;
$height = 300;

$name = $_GET['name'];
$all = (int) $_GET['all'];
$valid = intval($_GET['valid']);
$pc = $valid / $all * 100;

$x_name_length = $width / strlen($name) * 1.3;
$font_size = $x_name_length > 32 ? 32 : $x_name_length;

///die($x_name_length);

$image = imagecreate($width, $height);
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);

imagerectangle($image, 0, 0, $width-1, $height-1, $white);
imagettftext($image, $font_size, 0, 10, 10 + $font_size, $black, $font, $name);

imagettftext($image, $font_size, 0, 10, 100 + $font_size, $black, $font, "$valid / $all ({$pc}%)");

header("Content-type: image/png");
imagepng($image);
imagedestroy($image);
