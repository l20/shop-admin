<?php 
/**
 * 用户注册
 * @param  [type] $link [description]
 * @return [type]       [description]
 */
function reg($link){
	$arr=$_POST;
	$arr['password']=md5($_POST['password']);	
	$arr['regTime']=time();
	$uploadFile=uploadFiles("images/faceImg");	
	 		
	// print_r($uploadFile[0]['name']);exit;	
	if($uploadFile&&is_array($uploadFile)){
		$arr['face']=$uploadFile[0]['name'];
	}else{
		return "注册失败";
	}
//	print_r($arr);exit;
	if(insert("user", $arr, $link)){
		$mes="注册成功!<br/>3秒钟后跳转到登陆页面!<meta http-equiv='refresh' content='3;url=login.php'/>";
	}else{
		$filename="images/faceImg".$uploadFile[0]['name'];
		if(file_exists($filename)){
			unlink($filename);
		}
		$mes="注册失败!<br/><a href='reg.php'>重新注册</a>|<a href='index.php'>查看首页</a>";
	}
	return $mes;
}

/**
 * 用户登录
 * @param  [type] $link [description]
 * @return [type]       [description]
 */
function login($link){
	$username=$_POST['username'];
	//sql防注入
	//addslashes():使用反斜线引用特殊字符
	//$username=addslashes($username);
	$username=mysqli_escape_string($link, $username);
	$password=md5($_POST['password']);
	$sql="select * from user where username='{$username}' and password='{$password}'";
	//$resNum=getResultNum($sql);
	$row=fetchOne($sql, $link);
	//echo $resNum;
	if($row){
		$_SESSION['loginFlag']=$row['id'];
		$_SESSION['username'] =$row['username'];
		$mes="登陆成功！<br/>3秒钟后跳转到首页<meta http-equiv='refresh' content='3;url=index.php'/>";
	}else{
		$mes="登陆失败！<a href='login.php'>重新登陆</a>";
	}
	return $mes;
}

/**
 * 用户退出
 * @return [type] [description]
 */
function userOut(){
	$_SESSION=array();
	if(isset($_COOKIE[session_name()])){
		setcookie(session_name(),"",time()-1);
	}

	session_destroy();
	header("location:index.php");
}

 /**
  * 管理员添加用户操作
  * @param [type] $link [description]
  */
    function addUser($link){
        $arr = $_POST;
        $arr['password'] = md5($_POST['password']);
        $arr['regTime'] = time();
		$uploadFile=uploadFiles("../images/faceImg");	

		if($uploadFile&&is_array($uploadFile)){
			$arr['face']=$uploadFile[0]['name'];
		}else{
			return "添加失败<a href='addUser.php'>重新添加</a>";
		}

        if (insert("user", $arr, $link)) {
            $mes = "添加成功！<br><a href='addUser.php'>继续添加</a>|<a href='listUser.php'>查看用户</a>";
        }else{
            $mes = "添加失败！<br><a href='addUser.php'>重新添加</a>";
        }
        return $mes;
    }

    /**
     * 获取用户当前页码
     * @param  integer $pageSize [description]
     * @param  [type]  $link     [description]
     * @return [type]            [description]
     */
     function getUserByPage($pageSize=2, $link){
        $sql = "select * from user"; 
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

        $sql = "select * from user limit {$offset}, {$pageSize}";

        // 获取所有记录
        $rows = fetchAll($sql, $link);


        // $rows = getAllAdmin($link);
        if(!$rows) {
            alertMes("对不起，没有管理员，请添加！","addUser.php");
            
        }
        $arr = array();
        // $arr[0]
        return $rows;
    }

 	/**
     * 修改用户信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    function editUser($id, $link){
        // $sql = "update ";
        $arr = $_POST;
        $arr['password'] = md5($_POST['password']);
        // 若用户输未修改某个字段记录则使用原记录信息    
        if ($arr['username'] == null) unset($arr['username']);
        if ($arr['password'] == null) unset($arr['password']);
        if ($arr['email'] == null) unset($arr['email']);
        if ($arr['sex'] == null) unset($arr['sex']);
        print_r($arr);
        if ($arr['myFile'] == null){
        	 unset($arr['myFile']);
        }else{
        	$sql = "select face from user where id={$id}";
	    	$row = fetchOne($sql, $link);
	    	$face = $row['face'];

	        $uploadFile=uploadFiles("../images/faceImg");	

			if($uploadFile&&is_array($uploadFile)){
				$arr['face']=$uploadFile[0]['name'];
			}else{
				return "编辑失败！<a href='listUser.php'>重新修改</a>";
			}
			// 删除原图片
    		if (file_exists("../images/faceImg/".$face)) unlink("../images/faceImg/".$face);	
        }

        if (update("user", $arr, $link, "id={$id}")){
            $mes = "编辑成功! <a href='listUser.php'>查看管理员列表</a>";
        }else {
            $mes = "编辑失败！<a href='listUser.php'>请重新修改</a>";
        }

        return $mes;
    }

    /**
     * 删除用户
     * @param  [type] $id   [description]
     * @param  [type] $link [description]
     * @return [string]       [description]
     */
    function delUser($id, $link){
    	$sql = "select face from user where id={$id}";
    	$row = fetchOne($sql, $link);
    	$face = $row['face'];
    	// 删除图片
    	if (file_exists("../images/faceImg/".$face)) unlink("../images/faceImg/".$face);	
    	// 删除数据库中的记录
        if (delete("user", $link, "id={$id}")) {
            $mes = "删除成功！! <a href='listUser.php'>查看用户列表</a>";
        }else{
            $mes = "删除失败！! <a href='listUser.php'>查看用户列表</a>";
        }

        return $mes;
    }