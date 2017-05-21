<?php
	// require_once '../include.php';
	// require_once 'string.func.php';
		/**
		 *  通过GD库创建验证码
		 *  $width: 验证码图片宽度
		 *  $height: 验证码图片高度
		 *  $type:	产生字符类型，1为数字，2为数字和小写字母，3为数字小写字母加大写字母
		 *  $length: 验证码字符个数
		 *  $pixel: 干扰点数量
		 *  $line: 干扰线数量
		 *  $sess_name: session key
		 */
	function verifyImage($type = 1, $length = 4, $pixel = 0, $line = 0, $width = 80, $height = 20, $sess_name = "verify"){
		//使能session
		// session_start();
		// 创建画布
		// 创建真色彩画布
		$image = imagecreatetruecolor($width, $height);
		// 画笔颜色
		$white = imagecolorallocate($image, 255, 255, 255);
		$black = imagecolorallocate($image, 0, 0, 0);

		//用填充矩形填充画布
		imagefilledrectangle($image, 1, 1, $width-2, $height-2, $white);
		// 产生随机字符串
		$chars = buidRandomString($type, $length);
		// echo $chars."<br>";
		//存储到session
		$_SESSION[$sess_name] = $chars;
		// 字体数组
		$fontfiles = array("hye3gjm.TTF","hyh4gjm.TTF","hyk1gjm.TTF","STKAITI.TTF","STLITI.TTF","STXIHEI.TTF","STXINGKA.TTF","STZHONGS.TTF");
		// 随机获取数组中任意一个值
		$fontfile = "../fonts/".$fontfiles[mt_rand(0, count($fontfiles)-1)];


		/* 将TTF (TrueType Fonts) 字型文字写入图片*/

		for ($i=0; $i < $length; $i++) {
			//产生14 ~ 18的随机数用于字体大小
			$size = mt_rand(14, 18);
			//产生随机数用于字符角度
			$angle = mt_rand(-15, 15);
			//产生字符位置坐标
			$x = 5 + $i * $size;
			$y = mt_rand(15, 20);

			// 产生随机画笔颜色，用于设置字体颜色
			$color = imagecolorallocate($image, mt_rand(50, 90), mt_rand(80, 200), mt_rand(90, 180));
			$text = substr($chars, $i, 1);

			imagettftext($image, $size, $angle, $x, $y, $color, $fontfile, $text);
			
		}
		// 绘制点、线等干扰元素

		if ($pixel) {
			for ($i=0; $i < $pixel; $i++) {
				imagesetpixel($image, mt_rand(0, $width-1), mt_rand(0, $height-1), $black);
			}
		}

		if ($line) {
			for ($i=0; $i < $line; $i++) {
			$color = imagecolorallocate($image, mt_rand(50, 90), mt_rand(80, 200), mt_rand(90, 180));
				imageline($image, mt_rand(0, $width-1), mt_rand(0, $height-1), mt_rand(0, $width-1), mt_rand(0, $height-1), $color);
			}
		}

		// 输出图片格式
		header("content-type:image/gif");
		// 生成图片
		imagegif($image);
		// 释放资源
		imagedestroy($image);

	}

	/**
	 * 生成相应的缩略图
	 * @param  string  $filename        [要处理的文件名]
	 * @param  string  $destination     [生成文件保存的路径名]
	 * @param  inte    $dst_w           [要生成图片的宽度]
	 * @param  inte    $dst_h           [要生成图片的高度]
	 * @param  boolean $isReserveSource [是否要删除源文件：flase为删除]
	 * @param  float   $scale           [要生成图片的缩放比例]
	 * @return string                   [生成新文件的文件名]
	 */
	function thumb($filename, $destination=null, $dst_w=null, $dst_h=null, $isReserveSource=false, $scale=0.5){
		// 获取图片参数
		if (!empty($filename)) 
			list($src_w, $src_h, $imagetype) = getimagesize($filename);
		if (is_null($dst_w) || is_null($dst_h)) {
			$dst_w = ceil($src_w*$scale);
			$dst_h = ceil($src_h*$scale);

		}
		// 获取图片信息
		$mime = image_type_to_mime_type($imagetype);
		// 根据图片mime类型创建相应处理函数
		$creatFun = str_replace("/", "createfrom", $mime);
		// echo $creatFun;
		$outFun = str_replace("/", null, $mime);

		//imagecreatefromxxx();
		$src_image = $creatFun($filename);
		$dst_image = imagecreatetruecolor($dst_w, $dst_h);

		imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);

		//路径不存在则创建
		if ($destination && !file_exists(dirname($destination))) mkdir(dirname($destination), 0777, true); 

		if ($destination != null) {
			$dirs = explode("/", $destination);
	        $item1 = count($dirs);
	        $filen = explode(".", $dirs[$item1-1]);
	        $item2 = count($filen);

	        $destination = dirname($destination);
	       /* for ($i=0; $i < $item1-1; $i++) { 
	            $destination .= $dirs[$i]."/";
	        }*/
	        $destination .= "/".$filen[0]."_".$dst_w."x".$dst_h.".".$filen[$item2-1];


	        // $destination .= "_".$dst_w."×".$dst_h.".".$dirs[$item-1];
		}

		$dst_filename = $destination == null ? getUniName().$dst_w."x".$dst_h.".".getExt($filename) : $destination;
		// imagexxx()
		$outFun($dst_image, $dst_filename);
		imagedestroy($dst_image);
		imagedestroy($src_image);
		
		// 原图片文件是否删除标志位
		// $isReserveSource = false;删除
		if (!$isReserveSource) unlink($filename);
		// 返回生成的文件名
		return $dst_filename;

	}

	/**
	 * 给图片添加文字水印
	 * @param  string $filename 图片文件名
	 * @param  string $text     水印字符
	 * @param  string $fontfile 字体文件
	 * @return null             空
	 */			
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

	/**
	 * 给图片添加图片水印
	 * @param  string  $srcFile 水印图片
	 * @param  string  $dstFile 要打水印的图
	 * @param  integer $dst_x   目标图片坐标
	 * @param  integer $dst_y   
	 * @param  integer $src_x   水印图片在目标图片中的位置
	 * @param  integer $src_y   
	 * @param  integer $pct     水印图片透明度
	 * @return null             空
	 */
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
		header("content-type:".$dstMime);
		$outDstFunc($dst_im, "hello".".jpg");
		// 资源销毁
		imagedestroy($dst_im);
		imagedestroy($src_im);
	}