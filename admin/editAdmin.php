<?php 
	require_once '../include.php';

	$id = $_REQUEST['id'];
	$sql = "select id, username, password, email from admin where id = '{$id}'";
	$row = fetchOne($sql, $link);
	// print_r($row);

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<h3>编辑管理员</h3>
	<form action="doAdminAction.php?act=editAdmin&id=<?php echo $id ;?>" method="post">
		<table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
		<tr>
			<th>管理员名称</th>
			<td><input type="text" name="username" placeholder="<?php echo $row['username']; ?>"/></td>
		</tr>
		<tr>
			<th>管理员密码</th>
			<td><input type="password" name="password" placeholder="<?php echo $row['password']; ?>"/></td>
		</tr>
		<tr>
			<th>管理员邮箱</th>
			<td><input type="text" name="email" placeholder="<?php echo $row['email']; ?>"/></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="修改管理员" /></td>
		</tr>
	</table>
	</form>
</body>
</html>