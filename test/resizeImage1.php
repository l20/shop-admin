<?php 
	$filename = "des_big.jpg";
	list($src_w, $src_h, $imagetype) = getimagesize($filename);
	// 获取图片格式类型如：image/jpeg
	$mime = image_type_to_mime_type($imagetype);

	// echo $mime;
	//将“/”替换成“createFrom”，输出为 “image createFrom jpeg”
	$createFun = str_replace("/", "createFrom", $mime);

	$outFun = str_replace("/", null, $mime);
	$src_image = $createFun($filename);

	// $src_image = imagecreatefromjpeg($filename); 
	// 设置多种图片缩放规格
	$dst_50_image = imagecreatetruecolor(50, 50);
	$dst_220_image = imagecreatetruecolor(220, 220);
	$dst_350_image = imagecreatetruecolor(350, 350);
	$dst_800_image = imagecreatetruecolor(800, 800);
	// 采样
	imagecopyresampled($dst_50_image,  $src_image, 0, 0, 0, 0,  50,  50, $src_w, $src_h);
	imagecopyresampled($dst_220_image, $src_image, 0, 0, 0, 0, 220, 220, $src_w, $src_h);
	imagecopyresampled($dst_350_image, $src_image, 0, 0, 0, 0, 350, 350, $src_w, $src_h);
	imagecopyresampled($dst_800_image, $src_image, 0, 0, 0, 0, 800, 800, $src_w, $src_h);
	// 创建路径
	if (!file_exists("uploads/image_50/")) mkdir("uploads/image_50/", 0777, true);
	if (!file_exists("uploads/image_220/")) mkdir("uploads/image_220/", 0777, true);
	if (!file_exists("uploads/image_350/")) mkdir("uploads/image_350/", 0777, true);
	if (!file_exists("uploads/image_800/")) mkdir("uploads/image_800/", 0777, true);
	// 输出图片到路径保持
	$outFun($dst_50_image, "uploads/image_50/".$filename);
	$outFun($dst_220_image, "uploads/image_220/".$filename);
	$outFun($dst_350_image, "uploads/image_350/".$filename);
	$outFun($dst_800_image, "uploads/image_800/".$filename);
	// 释放图片资源
	imagedestroy( $dst_50_image);
	imagedestroy($dst_220_image);
	imagedestroy($dst_350_image);
	imagedestroy($dst_800_image);