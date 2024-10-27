<?php
session_start();

// Generate a random string for the CAPTCHA
$captcha_text = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, 6);
$_SESSION["captcha"] = $captcha_text;

// Create an image
$image = imagecreatetruecolor(100, 40);
$bg_color = imagecolorallocate($image, 255, 182, 193); // Light pink background
$text_color = imagecolorallocate($image, 0, 0, 0); // Black text

// Fill the image with background color
imagefill($image, 0, 0, $bg_color);

// Add the CAPTCHA text
imagestring($image, 5, 15, 10, $captcha_text, $text_color);

// Output the image
header("Content-type: image/png");
imagepng($image);
imagedestroy($image);
?>
