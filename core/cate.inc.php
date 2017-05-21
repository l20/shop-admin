<?php 
	// require_once '../include.php';

/*	global $table;
	$table = "cate";*/

	/**
	 * 添加分类操作
	 * @param [type] $link [description]
	 */
	function addCate($link){
		$arr = $_POST;
		if (insert("cate", $arr, $link)) {
			$mes = "分类添加成功！<br><a href='addCate.php'>继续添加</a> | <a href='listCate.php'>查看分类</a>";
		}else{
			$mes = "添加分类失败！<br><a href='addCate.php'>重新添加</a> | <a href='listCate.php'>查看分类</a>";
		}

		return $mes;
	}

	 /**
     * 修改分类名称
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    function editCate($id, $link){
        // $sql = "update ";
        $arr = $_POST;
        // 若用户输未修改某个字段记录则使用原记录信息    
        if ($arr['cName'] == null) unset($arr['cName']);

        if (update("cate", $arr, $link, "id={$id}")){
            $mes = "编辑成功! <a href='listCate.php'>查看分类</a>";
        }else {
            $mes = "编辑失败！<a href='listCate.php'>重新修改</a>";
        }

        return $mes;
    }

    /**
     * 删除管理员
     * @param  [type] $id   [description]
     * @param  [type] $link [description]
     * @return [string]       [description]
     */
    function delCate($id, $link){
        $res = checkProExist($id,$link);

        if (!$res){//检查相关的分类中没有信息可以删除该分类
            $where = "id=".$id;
            if (delete("cate", $link, $where)) {
                $mes = "删除成功！! <a href='listCate.php'>查看分类</a>";
            }else{
                $mes = "删除失败！! <a href='listCate.php'>查看分类</a>";
            }

            return $mes;
        }else{//该分类有信息，不能删除
            $mes = "不能删除该分类，因为该分类下有产品，请先删除商品。";
            alertMes($mes, "listPro.php");
        }
    }


	  /**
     * @param  integer 当前页码
     * @param  integer 每页显示条数
     * @return [type]
     */
    function getCateByPage($pageSize=2, $link){
        $sql = "select * from cate"; 
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

        $sql = "select * from cate order by id asc limit {$offset}, {$pageSize}";

        // 获取所有记录
        $rows = fetchAll($sql, $link);

        // $rows = getAllAdmin($link);
        if(!$rows) {
            alertMes("对不起，没有分类，请添加！","addCate.php");
            
        }
        $arr = array();
        // $arr[0]
        return $rows;
    }

    /**
     * 得到所有分类
     * @param  [type] $link [description]
     * @return [type]       [description]
     */
    function getAllCate($link){         
        $sql = "select * from cate";
        $rows = fetchAll($sql, $link);
        return $rows;
    }

    function getCateNameByCid($id,$link){
        $sql = "select cName from cate where id={$id}";
        $rows = fetchOne($sql, $link);
        return $rows;
        
    }