<?php 
	require_once '../include.php';

	$id = $_REQUEST['id'];
	$sql = "select * from cate where id = '{$id}'";
	$row = fetchOne($sql, $link);

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<h3>编辑分类</h3>
	<form action="doAdminAction.php?act=editCate&id=<?php echo $id ;?>" method="post">
		<table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
		<tr>
			<th>分类名称</th>
			<td><input type="text" name="cName" placeholder="<?php echo $row['cName']; ?>"/></td>
		</tr>
		<tr>
			<td colspan="3"><input type="submit" value="修改分类" /></td>
		</tr>
	</table>
	</form>
</body>
</html>