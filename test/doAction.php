<?php 
	require_once '../include.php';

	header("content-type:text/html;charset=utf-8");

	define('_1MB_', 1048567);
	define('_2MB_', 2097134);	
	define('_3MB_', 3145701);
	define('_4MB_', 4194268);

	// print_r($_FILES);exit;
	//获取文件信息 
	$fileInfo = $_FILES['myFile'];
	/*$type = $_FILES['myFile']['type'];
	$tmp_name = $_FILES['myFile']['tmp_name'];
	$error = $_FILES['myFile'][	'error'];
	$size = $_FILES['myFile']['size'];*/

	echo uploadFile($fileInfo);
