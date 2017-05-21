<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="doAction.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="MAX_FILE_SIZE">
		<label for="">请选择上传文件：</label>
		<input type="file" name="myFile" ><br>
		<input type="submit" value="上传">
	</form>
</body>
</html>