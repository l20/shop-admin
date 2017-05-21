<?php 
	// require_once '../include.php';

/*	$sql = "select * from admin"; 
	// 获取总记录条数
	$totalRows = getResultNum($sql, $link);

	// 每页要显示的条数
	$pageSize = 2;
	// 总页数
	$totalPage = ceil($totalRows/$pageSize);

	$page = $_REQUEST['page'] ? (int)$_REQUEST['page'] : 1;
	// 判断page 是否小于1，为空，非数字？
	if ($page<1 || $page==null || !is_numeric($page)) {
		$page = 1;
	}
	// 若所输入的page大于总页数
	if ($page >= $totalPage) {
		$page = $totalPage;
	}

	// 偏移量 = 当前页码 - 1 * 每页要显示的条数，page是用户点击时传过来的数据
	$offset = ($page - 1) * $pageSize;

	// echo $offset."<br>";
	$sql = "select * from admin limit {$offset}, {$pageSize}";

	// 获取所有记录
	$rows = fetchAll($sql, $link);

	foreach ($rows as $key) {
		echo "序	号:".$key['id']."|"."管理员名称:".$key['username']."|"."管理员邮箱:".$key['email']."<br>";
	}*/
	
	// 测试
	// echo "<hr>";
	// echo  showPage($page, $totalPage,"cid=5");

	function showPage($page, $totalPage, $where = null){
		$where = $where == null ? null : "&".$where;

		$url = $_SERVER['PHP_SELF'];
		$index = ($page==1) ? "首页" : "<a href='{$url}?page=1{$where}'>首页</a>" ;
		$last = ($page==$totalPage) ? "尾页" : "<a href='{$url}?page={$totalPage}{$where}'>尾页</a>" ;
		$prev = ($page==1) ? "上一页" : "<a href='{$url}?page=".($page-1)."{$where}'>上一页</a>";
		$next = ($page==$totalPage) ? "下一页" : "<a href='{$url}?page=".($page+1)."{$where}'>下一页</a>";
		$str = "总共 {$totalPage} 页/当前是第 {$page} 页";

		$p = "";

		for ($i=1; $i <= $totalPage; $i++) { 
			// 若为当前页则无连接
			if ($page == $i) {
				$p .= "[{$i}]";

			}else{
				$p .= "[<a href='{$url}?page={$i}'>{$i}</a>]";
			}
		}

		 $pageStr =  $str." "."|"." ".$index." ".$prev." ".$p." ".$next." ".$last;

		 return $pageStr;
	}