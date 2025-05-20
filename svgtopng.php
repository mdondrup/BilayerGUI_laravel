<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

phpinfo();
/*
$usmap = 'CHOL.svg';
$im = new Imagick();
$svg = file_get_contents($usmap);

$im->readImageBlob($svg);

$im->setImageFormat("png24");
$im->resizeImage(720, 445, imagick::FILTER_LANCZOS, 1); 

$im->writeImage('blank-us-map.png');

header('Content-type: image/png');
echo $im;

$im->clear();
$im->destroy();
*/
?>
