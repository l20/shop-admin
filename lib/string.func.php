<?php 

	// 产生随机数
	function buidRandomString($type=1, $length = 4){

		// 根据参数类型，产生数字、数字小写字母、数字小写字母大写字母等字符
		if ($type == 1) {
			$chars = join("", range(0, 9));
		}elseif ($type == 2) {
			$chars = join("", array_merge(range("a","z"), range("A", "Z")));
		}elseif ($type == 3) {
			$chars = join("", array_merge(range("a","z"), range("A", "Z"), range(0, 9)));
		}

		if ($length > strlen($chars)) {
			exit("字符串长度不够");
		}
		// 随机地打乱字符串中的所有字符
		$chars = str_shuffle($chars);
		// 截取制定长度字符
		return substr($chars, 0, $length);

	}

	/**
	 * 生成唯一字符串
	 * @return [type] [description]
	 */
	function getUniName(){
		return md5(uniqid(microtime(true), true));
	}

	/**
	 * 得到文件的扩展名
	 * @param  [type] $filename [description]
	 * @return [type]           [description]
	 */
	function getExt($filename){
		//strtolower()把所有字符转换为小写
		//end() 返回数组的当前元素的值和最后元素的值
		//explode() 返回将字符串按“.”分割后的数组
		$str = explode(".", $filename);
		return strtolower(end($str));

	}