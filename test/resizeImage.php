<?php 
	// 生成图片缩略图
	$filename = "des_big.jpg";
	$src_image = imagecreatefromjpeg($filename);
	list($src_w, $src_h) = getimagesize($filename);

	//定义缩放比例
	$scale = 0.5;
	// 宽*缩放比例
	$dst_w = ceil($src_w*$scale);
	$dst_h = ceil($src_h*$scale);
	// 生成真色彩图片
	$dst_image = imagecreatetruecolor($dst_w, $dst_h);

	// 图片重新采样
	/**
	 * $dst_image：新建的图片
	 * 
	 *	$src_image：需要载入的图片
	 *
	 *	$dst_x：设定需要载入的图片在新图中的x坐标
	 *
	 *	$dst_y：设定需要载入的图片在新图中的y坐标
  	 *
	 *	$src_x：设定载入图片要载入的区域x坐标
	 *
	 *	$src_y：设定载入图片要载入的区域y坐标
	 *
	 *	$dst_w：设定载入的原图的宽度（在此设置缩放）
	 *
	 *	$dst_h：设定载入的原图的高度（在此设置缩放）
	 *
	 *	$src_w：原图要载入的宽度
	 *
	 *  $src_h：原图要载入的高度	
	 */
	imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);

	// header("content-type:image/gif");
	header("content-type:image/jpeg");
	// imagegif($dst_image);
	imagejpeg($dst_image,"uploads/".$filename);
	// 释放资源
	imagedestroy($src_image);
	imagedestroy($dst_image);