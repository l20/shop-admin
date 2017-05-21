<?php 
	/**
	 * 添加商品
	 * @param [type] $link [description]
	 */
	function addPro($link){
		$arr = $_POST;
		$arr['pubTime'] = time();
		//上传图片
		$path = "./uploads";
		$uploadFiles = uploadFiles($path);
		// 生成缩略图
		if (is_array($uploadFiles) && $uploadFiles) {

			foreach ($uploadFiles as $key => $uploadFile) {
				echo thumb($path."/".$uploadFile['name'],  "../images_50/".$uploadFile['name'],  50,  50, true)."<br>";
				echo thumb($path."/".$uploadFile['name'], "../images_220/".$uploadFile['name'], 220, 220, true)."<br>";
				echo thumb($path."/".$uploadFile['name'], "../images_350/".$uploadFile['name'], 350, 350, true)."<br>";
				echo thumb($path."/".$uploadFile['name'], "../images_800/".$uploadFile['name'], 800, 800, true)."<br>";
			}
		}

		// print_r($arr);
		$res = insert("product", $arr, $link);
		// 获取上一条插入记录ID
		$pid = getInsertId($link);

		if ($res && $pid) { //商品添加成功
			foreach ($uploadFiles as $key => $uploadFile) {
				$arr1['pid'] = $pid;
				$arr1['albumPath'] = $uploadFile['name'];
				addAlbum($arr1, $link);	

			}
			$mes = "<p>添加成功！</p><a href='addPro.php' target='mainFrame'>继续添加</a> | <a href='listPro.php' target='mainFrame'>查看商品列表</a>" ;
		}else{//商品添加失败则删除原图片
			foreach ($uploadFiles as $key => $uploadFile) {
				if (file_exists("../image_800/".$uploadFile['name'])) unlink("../image_800/".$uploadFile['name']);
				if (file_exists("../image_50/".$uploadFile['name'])) unlink("../image_50/".$uploadFile['name']);
				if (file_exists("../image_220/".$uploadFile['name'])) unlink("../image_220/".$uploadFile['name']);
				if (file_exists("../image_350/".$uploadFile['name'])) unlink("../image_350/".$uploadFile['name']);
			}
			$mes = "<p>添加失败！</p><a href='addPro.php' target='mainFrame'>重新添加</a>" ;
		}

		return $mes;
	}

	/**
	 * 获取所有商品信息
	 * @param  [type] $link [description]
	 * @return array       [description]
	 */

	function getAllProByAdmin($link){
		$sql = "select p.id, p.pName, p.Sn, p.cNum, p.mPrice, p.iPrice, p.pDesc, p.pubTime, p.isShow, p.isHot, c.cName from product as p join cate c on p.cId=c.id";
		$rows = fetchAll($sql, $link);

		return $rows;
	}

	/**
	 * 获取商品所有图片信息
	 * @param  [type] $id   [description]
	 * @param  [type] $link [description]
	 * @return array       [description]
	 */
	function getAllImgByProId($id,$link){
		$sql = "select a.albumPath from album a where pid={$id}";

		$rows = fetchAll($sql, $link);

		return $rows;
	}

	/**
	 * 根据ID得到商品详细信息
	 * @param  int $id   [description]
	 * @param  string $link [description]
	 * @return array       [description]
	 */
	function getProById($id, $link){
		$sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from product as p join cate c on p.cId=c.id where p.id={$id}";
		$row = fetchOne($sql, $link);

		return $row;
	}

	/**
	 * 编辑商品
	 * @param  int 
	 * @return string     
	 */
	function editPro($id,$link){
		$arr = $_POST;
		//上传图片
		$path = "./uploads";
		$uploadFiles = uploadFiles($path);
		// 生成缩略图
		// $renames = array();
		$i = 0;
		if (is_array($uploadFiles) && $uploadFiles) {
			foreach ($uploadFiles as $key => $uploadFile) {
				$srcFilen = $uploadFile['name'];
				$renames[$i]['name_50'] = thumb($path."/".$srcFilen,  "../images_50/".$srcFilen,  50,  50, true);
				$renames[$i]['name_220'] =  thumb($path."/".$srcFilen, "../images_220/".$srcFilen, 220, 220, true);
				$renames[$i]['name_350'] =  thumb($path."/".$srcFilen, "../images_350/".$srcFilen, 350, 350, true);
				$renames[$i]['name_800'] =  thumb($path."/".$srcFilen, "../images_800/".$srcFilen, 800, 800, true);
				$i++;
			}
		}

		// print_r($renames);
		// 用户其他相关字段未修改则删掉相关字段，防止相关信息未修改为空的情况
        if ($arr['pName'] == null) 	unset($arr['pName']);
        if ($arr['cName'] == null) 	unset($arr['cName']);
        if ($arr['pSn'] == null) 	unset($arr['pSn']);
        if ($arr['pNum']== null) 	unset($arr['pNum']);
        if ($arr['mPrice'] == null) unset($arr['mPrice']);
        if ($arr['iPrice'] == null) unset($arr['iPrice']);


		$where = "id={$id}";
		$res = update("product", $arr, $link, $where);
		$pid = $id;
		if ($res && $pid) { //商品添加成功
			foreach ($uploadFiles as $key => $uploadFile) {
				$arr1['pid'] = $pid;
				$arr1['albumPath'] = $uploadFile['name'];
				addAlbum($arr1, $link);	
			}
			$mes = "<p>编辑成功！</p> | <a href='listPro.php' target='mainFrame'>查看商品列表</a>" ;
		}else{	//商品添加失败则删除原图片
            foreach ($renames as $key => $rename) {
				if (file_exists($rename['name_50']))  unlink($rename['name_50'] );
				if (file_exists($rename['name_220'])) unlink($rename['name_220']);
				if (file_exists($rename['name_350'])) unlink($rename['name_350']);
				if (file_exists($rename['name_800'])) unlink($rename['name_800']);

			}
			foreach ($uploadFiles as $key => $uploadFile) {
				if (file_exists($path."/".$uploadFile['name'])) unlink($path."/".$uploadFile['name']);
			}
			
			$mes = "<p>编辑失败！</p><a href='editPro.php' target='mainFrame'>重新编辑</a>" ;
		}

		return $mes;
	}


	function delPro($id, $link){
		$where = "id={$id}";
		$res1 = delete("product", $link, $where);
		$proImgs = getAllImgByProId($id, $link);	

		if ($proImgs && is_array($proImgs)) {
			foreach ($proImgs as $proImg) {
				$destination = $proImg['albumPath'];

				if (file_exists("./uploads/".$destination)) unlink("./uploads/".$destination);

				if ($destination != null) {
			        $filen = explode(".", $destination);
			        $item = count($filen);
			   	}

			        $destinations['img50']  = "../images_50/".$filen[0]."_"."50x50".".".$filen[$item-1];
			        $destinations['img220'] = "../images_220/".$filen[0]."_"."220x220".".".$filen[$item-1];
			        $destinations['img350'] = "../images_350/".$filen[0]."_"."350x350".".".$filen[$item-1];
			        $destinations['img800'] = "../images_800/".$filen[0]."_"."800x800".".".$filen[$item-1];

					if(file_exists($destinations['img50'])) unlink($destinations['img50']);
					if(file_exists($destinations['img220'])) unlink($destinations['img220']);
					if(file_exists($destinations['img350'])) unlink($destinations['img350']);
					if(file_exists($destinations['img800'])) unlink($destinations['img800']);
			}
		}
		$where = "pid={$id}";
		$res2 = delete("album", $link, $where);

		if ($res1 && $res2) 
			$mes = "删除成功！| <a href='listPro.php'>查看商品列表</a>";
		else
			$mes = "删除失败！| <a href='listPro.php'>返回商品列表</a>继续操作。";
		
		return $mes;
	}

	/**
	 * 检查分类下是否有产品
	 * @param  int $cid   产品ID
	 * @param  mult $link 数据库链接
	 * @return array      返回结果集
	 */
	function checkProExist($id, $link){
		$sql = "select * from product where cId={$id}";

		$rows = fetchAll($sql, $link);
		return $rows;
	}

	/**
	 * 得到所有商品
	 * @param  [type] $link 数据库链接
	 * @return array       所有商品结果集
	 */
	function getPros($link){
		$sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from product as p join cate c on p.cId=c.id";

		$rows = fetchAll($sql, $link);
		return $rows;
	}

	/**
	 * 根据商品分类类型得到商品
	 * @param  [type] $linl [description]
	 * @return [type]       [description]
	 */
	function getProsByCid($cid,$link){
		$sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from product as p join cate c on p.cId=c.id where p.cId={$cid} limit 4";
		$rows = fetchAll($sql, $link);

		return $rows;

	}

	/**
	 * 根据产品cid得到下4条商品信息	
	 * @param  [type] $cid  [description]
	 * @param  [type] $link [description]
	 * @return [type]       [description]
	 */
	function getSmallProsByCid($cid,$link){
		$sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from product as p join cate c on p.cId=c.id where p.cId={$cid} limit 4,4";
		$rows = fetchAll($sql, $link);

		return $rows;

	}

	/**
	 * 得到商品ID、名称
	 * @param  [type] $link 数据库连接
	 * @return array       结果集
	 */
	function getProInfo($link){
		$sql = "select id, pName from product order by id asc";
		$rows = fetchAll($sql, $link);

		return $rows;
	}