<?php 
	require_once '../include.php';

    $pageSize = 4;
    $rows = getCateByPage($pageSize, $link);
    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>添加分类</title>
<link rel="stylesheet" href="styles/backstage.css">
</head>
<body>
<div class="details">
                    <div class="details_operation clearfix">
                        <div class="bui_select">
                            <input type="button" value="添&nbsp;&nbsp;加" class="add"  onclick="addCate()">
                        </div>
                            
                    </div>
                    <!--表格-->
                    <table class="table" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="5%">编号</th>
                                <th width="30%">分类名称</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  foreach($rows as $row):?>
                            <tr>
                                <td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $row['id']; ?></label></td>
                                <td><?php echo $row['cName']; ?></td>
                                <td align="center">
                                    <input type="button" value="修改" class="btn" onclick="editCate(<?php echo $row['id']; ?>)">
                                    <input type="button" value="删除" class="btn"  onclick="delCate(<?php echo $row['id']; ?>)">
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <!-- 显示页码 -->
                            <?php if ($rows>$pageSize): ?>
                            <tr>
                                <td colspan="3"><?php echo showPage($page, $totalPage); ?></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
</body>
<script type="text/javascript">
	function addCate(){
		window.location = "addCate.php";
	}

	function editCate(id){
		window.location = "editCate.php?id=" + id;
	};

	function delCate(id){
		if(window.confirm("您确定要删除吗？此操作不可恢复！！！")){
			window.location = "doAdminAction.php?act=delCate&id=" + id;

		}

	};
</script>
</html>