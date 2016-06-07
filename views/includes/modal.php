<?php
Yii::$app->response->headers->add('Content-type', 'image/png');
header("Content-type: image/png");
$im = imagecreatefrompng("img/china-blog-post-zachem-uchit-screenshot-12.png");
$ink = imagecolorallocate($im, 255, 255, 255);

imagearc($im,160,120,200,150,0,360,$ink);

imagepng($im);
imagedestroy($im);

?>
