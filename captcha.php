<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Config/Session.php';

// Set the content-type
header('Content-Type: image/png');

$captcha = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 4); // string yang akan diacak membentuk captcha 0-z dan sebanyak 6 karakter
$_SESSION['captcha'] = $captcha; //set session dengan nama captcha dimana isinya adalah isi dari variabel $captcha

$pic = imagecreate(40,20);// ukuran kotak width=60 dan height=20
$box_color = imagecolorallocate($pic, 217, 217, 217); // membuat warna box
$text_color = imagecolorallocate($pic, 0, 0, 0); // membuat warna tulisan

imagefilledrectangle($pic, 0, 0, 50, 20, $box_color);
imagestring($pic, 5, 3, 3, $captcha, $text_color);
imagepng($pic);