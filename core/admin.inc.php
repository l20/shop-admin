<?php

    // require_once '../include.php';

	/**
	 * 检查是否有管理员账户记录信息
	 * @param  [type] $sql  [description]
	 * @param  [type] $link [description]
	 * @return [type]       [description]
	 */
    function checkAdmin($sql, $link){
        return fetchOne($sql, $link);
    }
    
    /**
     * 检查管理员是否已经登录
     * @return [type] [description]
     */
    function checkLogined(){
    	if ($_SESSION['adminId'] == "" && $_COOKIE['adminId'] == "") {
    		alertMes("请先登录。", "login.php");
    	}
    }

    /**
     * 退出登录
     * @return [type] [description]
     */
    function logout(){
    	$_SESSION = array();
    	if (isset($_SESSION[session_name()])) {
    		setcookie(session_name(), "", time()-1);
    	}
    	if (isset($_COOKIE['adminId'])) {
    		setcookie("adminId", "", time()-1);
    	}
    	if (isset($_COOKIE['adminName'])) {
    		setcookie("adminName", "", time()-1);
    	}
    	session_destroy();
    	alertMes("退出成功", "login.php");
    }

    /**
     * 添加管理员
     * @param [multiptype] $link [数据库链接]
     */
    function addAdmin($link){
    	$arr = $_POST;
        $arr['password'] = md5($_POST['password']);
    	if (insert("admin", $arr, $link)) {
    		$mes = "添加成功！<br><a href='addAdmin.php'>继续添加</a>|<a href='listAdmin.php'>查看管理员</a>";
    	}else{
    		$mes = "添加失败！<br><a href='addAdmin.php'>重新添加</a>";
    	}
    	return $mes;
    }

    /**
     * 获取所有管理员用户
     * @param  [type] $link [数据库链接]
     * @return [array]       [相关字段的记录]
     */
    function getAllAdmin($link){
        $sql = "select id, username, email from admin"; 
        $rows = fetchAll($sql, $link);

        return $rows;
    }

    /**
     * @param  integer 当前页码
     * @param  integer 每页显示条数
     * @return [type]
     */
    function getAdminByPage($pageSize=2, $link){
        $sql = "select * from admin"; 
        // 获取总记录条数
        $totalRows = getResultNum($sql, $link);

        // 每页要显示的条数
        // $pageSize = 2;

        // 总页数
        global $totalPage;
        global $page;
        $totalPage = ceil($totalRows/$pageSize);

        $page = $_REQUEST['page'] ? (int)$_REQUEST['page'] : 1;
        // 判断page 是否小于1，为空，非数字？
        if ($page<1 || $page==null || !is_numeric($page)) {
            $page = 1;
        }
        // 若所输入的page大于总页数
        if ($page >= $totalPage)  $page = $totalPage;

        // 偏移量 = 当前页码 - 1 * 每页要显示的条数，page是用户点击时传过来的数据
        $offset = ($page - 1) * $pageSize;

        $sql = "select id, username, email from admin limit {$offset}, {$pageSize}";

        // 获取所有记录
        $rows = fetchAll($sql, $link);


        // $rows = getAllAdmin($link);
        if(!$rows) {
            alertMes("对不起，没有管理员，请添加！","addAdmin.php");
            
        }
        $arr = array();
        // $arr[0]
        return $rows;
    }

    /**
     * 修改管理员信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    function editAdmin($id, $link){
        // $sql = "update ";
        $arr = $_POST;
        $arr['password'] = md5($_POST['password']);
        // 若用户输未修改某个字段记录则使用原记录信息    
        if ($arr['username'] == null) unset($arr['username']);
        if ($arr['password'] == null) unset($arr['password']);
        if ($arr['email'] == null) unset($arr['email']);

        if (update("admin", $arr, $link, "id={$id}")){
            $mes = "编辑成功! <a href='listAdmin.php'>查看管理员列表</a>";
        }else {
            $mes = "编辑失败！<a href='listAdmin.php'>请重新修改</a>";
        }

        return $mes;
    }

    /**
     * 删除管理员
     * @param  [type] $id   [description]
     * @param  [type] $link [description]
     * @return [string]       [description]
     */
    function delAdmin($id, $link){
        if (delete("admin", $link, "id={$id}")) {
            $mes = "删除成功！! <a href='listAdmin.php'>查看管理员列表</a>";
        }else{
            $mes = "删除失败！! <a href='listAdmin.php'>查看管理员列表</a>";
        }

        return $mes;
    }

   
