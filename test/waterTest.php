<?php 

$filename = "des_big.jpg";
waterText($filename);
function  waterText($filename, $text="hello world", $fontfile="STKAITI.TTF"){

	$fileInfo = getimagesize($filename);
	$mime = $fileInfo["mime"];

	$createFun = str_replace("/", "createfrom", $mime);
	$image = $createFun($filename);

	$outFun = str_replace("/", null, $mime);

	$fontfile = "../fonts/{$fontfile}";
	$color = imagecolorallocatealpha($image, 255, 0, 0, 60);
	imagettftext($image, 30, 15, 250, 250, $color, $fontfile, $text);

	header("content-type:".$mime);
	$outFun($image, "hello.jpg");
	imagedestroy($image);
}
