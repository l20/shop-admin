<?php
	require_once '../include.php';

	$act = $_REQUEST['act'];
	$id = $_REQUEST['id'];

	if ($act == "logout") {//退出登录
		logout();
	}elseif ($act == "addAdmin") { //增加管理员
		$mes = addAdmin($link);
	}elseif ($act == "editAdmin") { //修改管理员
		$mes = editAdmin($id, $link);
	}elseif ($act == "delAdmin") { //删除管理员
		$mes = delAdmin($id, $link);
	}elseif ($act == "addCate") { //添加分类
		$mes = addCate($link);
	}elseif ($act == "editCate") {//修改分类
		$mes = editCate($id, $link);
	}elseif ($act == "delCate") { //删除分类
		$mes = delCate($id, $link);
	}elseif ($act == "addPro") { //添加商品
		$mes = addPro($link);
	}elseif ($act == "editPro") { //编辑商品信息
		$mes = editPro($id, $link);
	}elseif ($act == "delPro") {//删除商品
		$mes = delPro($id, $link);
	}elseif ($act == "addUser") {//添加用户
		$mes = addUser($link);
	}elseif ($act == "editUser") {//编辑用户
		$mes = editUser($id, $link);
	}elseif ($act == "delUser") {//删除用户
		$mes = delUser($id, $link);
	}elseif ($act == "waterText") {//给图片添加文字水印
		$mes = doWaterText($id, $link);
	}elseif ($act == "waterPic") {//给图片添加图片水印
		$mes = doWaterPic($id, $link);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>	
<body>
	<?php  if ($mes) echo $mes."<br>"; ?>
</body>
</html>