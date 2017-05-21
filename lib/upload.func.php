<?php 
	/**
	 * 上传单个文件
	 * @param  [type]  $fileInfo [description]
	 * @param  string  $path     [description]
	 * @param  array   $allowExt [description]
	 * @param  integer $maxSize  [description]
	 * @param  boolean $imgFlag  [description]
	 * @return [type]            [description]
	 */
	function uploadFile($path = "uploads", $allowExt = array("gif", "jpeg", "jpg", "png", "bmp", "wbmp", "tif"), $maxSize=2097134, $imgFlag = true ){
		
		// 限制允许上传的文件格式，防止上传病毒木马攻击

		// $maxSize = 1M ;

		$fileInfo = buildInfo();
		print_r($fileInfo);exit();

		if ($fileInfo['error'] == UPLOAD_ERR_OK) { //上传正常
			// 获取文件扩展名
			$ext = getExt($fileInfo['name']);

			/*限制文件类型*/
			// 判断上传的文件是否是允许的文件
			// in_array()函数：在第二个参数数组中搜索指定（第一参数）的值是否存在
			if (!in_array($ext, $allowExt)) { //不是允许的文件格式
				$mes = "非法文件类型";
				exit($mes);
			}

			/*限制文件大小*/
			if ($fileInfo['size'] > $maxSize) {
				$mes = "文件过大";
				exit($mes);
			}

			/*验证一张图片是否是真正的图片类型*/
			if ($imgFlag) {
				// 通过 getimagesize()函数验证文件是否是一张真正的图片，是图片返回图片相关信息的数组，不是图片返回 bool(fales)
				$info = getimagesize($fileInfo['tmp_name']);
				// var_dump($info);exit;
				if (!$info) {
					exit("不是一张真正的图片类型");
				}
			}

			// 设置文件名的唯一性
			$filename = getUniName().".".$ext;
			
			$path = "uploads";
			// 判断路径是否存在
			if (!file_exists($path)) {
				mkdir($path, 0777, true);//创建路径
			}
			$destination = $path."/".$filename;
			
			// 需要判断文件是否是通过HTTP POST方式上传文件
			if (is_uploaded_file($fileInfo['tmp_name'])) { //文件是通过POST方式上传
				if (move_uploaded_file($fileInfo['tmp_name'], $destination)) { //将临时文件移动到指定目录下
					$mes = "文件上传成功";

				}else{
					$mes = "文件移动失败";
				}
			}else{ //不是POST方式上传
				$mes = "文件不是通过HTTP POST方式上传文件";
			}

		}else{ //上传出错
			switch ($fileInfo['error']) {
				case 1:
					$mes = "超过了配置文件上传文件的大小";//所上传文件超出指定大小 error值的宏是 UPLOAD_ERR_INI_SIZE
					break;
				case 2:
					 $mes = "超过了表单设置的上传文件的大小"; //UPLOAD_ERR_FORM_SIZE
					break;
				case 3:
					$mes = "文件部分被上传"; //UPLOAD_ERR_PARTIAL
					break;
				case 4:
					$mes = "文件没有被上传"; //UPLOAD_ERR_NO_FILE
					break;
				case 6:
					$mes = "没有找到临时目录"; //UPLOAD_ERR_NO_TMP_DIR
					break;
				case 7:
					$mes = "文件不可写"; //UPLOAD_ERR_NO_CANT_WRITE
					break;
				case 8:
					$mes = "由于PHP的扩展程序中断了文件上传";
					break;
				default:
					# code...
					break;
			}
		}

		return $mes;

			//一、服务器端php.ini 文件进行配置
			//1. file_uploads = On ,支持通过HTTP POST方式上传文件
			//2. upload_tmp_dir = "D:/wamp/tmp" ，临时文件保存目录
			//3. upload_max_filesize = 64M  ，表单上传文件的最大大小  
			//4. post_max_size = 3M ，表单以POST方式发送的最大文件大小
			//
			//二、客户端进行配置
			//<input type="hidden" name="MAX_FILE_SIZE" value="1024"> 客户端限制文件大小
			//<input type="file" name="myFile" accept="image/jpeg,image/png,image/gif"> 客户端限制文件类型
			

	}

	/**
	 * 上传多文件
	 * @param  string  $path     [description]
	 * @param  array   $allowExt [description]
	 * @param  integer $maxSize  [description]
	 * @param  boolean $imgFlag  [description]
	 * @return [type]            [description]
	 */
	function uploadFiles( $path = "uploads", $allowExt = array("gif", "jpeg", "jpg", "png", "bmp", "wbmp", "tif"), $maxSize=2097134, $imgFlag = true ){
		
		$i=0;
		$mes = '';
		$files = buildInfo();
		if (!$files) return false;
		foreach ($files as $file) {

			if ($file['error'] == UPLOAD_ERR_OK) { //上传正常
				// 获取文件扩展名
				$ext = getExt($file['name']);

				/*限制文件类型*/
				// 判断上传的文件是否是允许的文件
				// in_array()函数：在第二个参数数组中搜索指定（第一参数）的值是否存在
				if (!in_array($ext, $allowExt)) { //不是允许的文件格式
					$mes = "非法文件类型";
					exit($mes);
				}

				/*限制文件大小*/
				if ($file['size'] > $maxSize) {
					$mes = "文件过大";
					exit($mes);
				}

				/*验证一张图片是否是真正的图片类型*/
				if ($imgFlag) {
					// 通过 getimagesize()函数验证文件是否是一张真正的图片，是图片返回图片相关信息的数组，不是图片返回 bool(fales)
					$info = getimagesize($file['tmp_name']);
					// var_dump($info);exit;
					if (!$info) {
						exit("不是一张真正的图片类型");
					}
				}

				// 设置文件名的唯一性
				$filename = getUniName().".".$ext;
				
				// $path = "uploads";
				// 判断路径是否存在
				if (!file_exists($path)) {
					mkdir($path, 0777, true);//创建路径
				}
				$destination = $path."/".$filename;
				
				// 需要判断文件是否是通过HTTP POST方式上传文件
				if (is_uploaded_file($file['tmp_name'])) { //文件是通过POST方式上传
					if (move_uploaded_file($file['tmp_name'], $destination)) { //将临时文件移动到指定目录下
						$file['name']=$filename;
						unset($file['error'],$file['tmp_name'],$file['size'],$file['type']);
						$uploadedFiles[$i]=$file;
						$mes = "文件".$files[$i]['name']."上传成功"."<br>	";
						$i++;
					}	
				}else{ //不是POST方式上传
					$mes = "文件不是通过HTTP POST方式上传文件";
				}

			}else{ //上传出错
				switch ($file['error']) {
					case 1:
						$mes = "超过了配置文件上传文件的大小";//所上传文件超出指定大小 error值的宏是 UPLOAD_ERR_INI_SIZE
						break;
					case 2:
						 $mes = "超过了表单设置的上传文件的大小"; //UPLOAD_ERR_FORM_SIZE
						break;
					case 3:
						$mes = "文件部分被上传"; //UPLOAD_ERR_PARTIAL
						break;
					case 4:
						$mes = "文件没有被上传"; //UPLOAD_ERR_NO_FILE
						break;
					case 6:
						$mes = "没有找到临时目录"; //UPLOAD_ERR_NO_TMP_DIR
						break;
					case 7:
						$mes = "文件不可写"; //UPLOAD_ERR_NO_CANT_WRITE
						break;
					case 8:
						$mes = "由于PHP的扩展程序中断了文件上传";
						break;
				}
			}
				echo $mes;
		}

		return $uploadedFiles;	

	}

	/**
	 * 构建上传文件信息
	 * @return array 
	 */
	function buildInfo(){
		if ($_FILES == null) return false;
		$i=0;
		foreach($_FILES as $v){
			//单文件
			if(is_string($v['name'])){
				$files[$i]=$v;
				$i++;
			}else{
				//多文件
				foreach($v['name'] as $key=>$val){
					$files[$i]['name']=$val;
					$files[$i]['size']=$v['size'][$key];
					$files[$i]['tmp_name']=$v['tmp_name'][$key];
					$files[$i]['error']=$v['error'][$key];
					$files[$i]['type']=$v['type'][$key];	
					$i++;
				}
			}
		}
		return $files;
	}
