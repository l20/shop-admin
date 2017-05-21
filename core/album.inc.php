<?php 
	function addAlbum($arr,$link){
		insert("album", $arr, $link);
	}

	/**
	 * 根据商品id得到商品图片
	 * @param  int $id   商品ID	
	 * @param  mtl $link 数据库链接	
	 * @return array     一条记录信息
	 */
	function getProImgById($id, $link){
		$sql = "select albumPath from album where pid={$id} limit 1";

		$rows = fetchAll($sql, $link);

		return $rows;
	}

	function getSmallImgById($id, $link){
		$sql = "select albumPath from album where pid={$id} limit 4";

		$rows = fetchAll($sql, $link);

		return $rows;
	}

	/**
	 * 给所有图片添加文字水印
	 * @param  [type] $id   [description]
	 * @param  [type] $link [description]
	 * @return [type]       [description]
	 */
	function doWaterText($id, $link){
		$rows = getProImgById($id, $link);	
		foreach ($rows as $row) {
			$filename = "uploads/".$row['albumPath'];
			waterText($filename);
		}
	}

	/**
	 * 给所有图片添加文字水印
	 * @param  [type] $id      [description]
	 * @param  [type] $link    [description]
	 * @param  [type] $srcFile 水印图片
	 * @return [type]          [description]
	 */
	function doWaterPic($id, $link, $srcFile){
		$rows = getProImgById($id, $link);	
		foreach ($rows as $row) {
			$filename = "uploads/".$row['albumPath'];
			waterPic($srcFile, $filename);
		}
	}