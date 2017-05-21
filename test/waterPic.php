<?php 
$srcFile = "../images/logo.jpg";
$dstFile = "des_big.jpg";

waterPic($srcFile, $dstFile);

function waterPic($srcFile, $dstFile, $dst_x=0, $dst_y=0, $src_x=0, $src_y=0, $pct=60){
	// 获取图片信息
	$srcFileInfo = getimagesize($srcFile);
	$src_w = $srcFileInfo[0];
	$src_h = $srcFileInfo[1];
	$dstFileInfo = getimagesize($dstFile);

	$srcMime = $srcFileInfo['mime'];
	$dstMime = $dstFileInfo['mime'];

	$createSrcFunc = str_replace("/", "createfrom", $srcMime);
	$createDstFunc = str_replace("/", "createfrom", $dstMime);

	$outDstFunc = str_replace("/", null, $dstMime);
	$dst_im = $createDstFunc($dstFile);
	$src_im = $createSrcFunc($srcFile);


	/**
	 * 将一张图片附加到另一张图片中
	 * @param  [type] $dst_im 要附加的目标图片	
	 * @param  [type] $src_im 原图片
	 * @param  [type] $dst_x  目标图片坐标
	 * @param  [type] $dst_y 
	 * @param  [type] $src_x  原图片坐标
	 * @param  [type] $src_y  
	 * @param  [type] $src_w  原图片大小
	 * @param  [type] $src_h  
	 * @param  [type] $pct    源图片透明度（水印）
	 * @return [type]         [description]
	 */
	imagecopymerge($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct);
	// 图片输出
	// header("content-type:".$dstMime);
	$outDstFunc($dst_im, "hello".".jpg");
	// 资源销毁
	imagedestroy($dst_im);
	imagedestroy($src_im);
}