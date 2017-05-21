<?php
    // require_once '../include.php';
    // header("Content-type: text/html; charset=utf-8");   

    /**
     * 连接数据库
     * @return unknown
     */
    function connet(){
        $link = mysqli_connect(DB_HOST, DB_USER,DB_PWD) or die("数据库连接失败Error:".mysqli_errno($link).":".mysqli_error($link));
        mysqli_set_charset($link, DB_CHARSET);
        mysqli_select_db($link, DB_DBNAME) or die("指定数据库打开失败");

        return $link;
    }
    /**
     * 完成插入记录的操作
     * @param 表名 $table
     * @param 数据 $array
     * @param 数据库链接 $link
     */
    function insert($table, $array, $link){
        $keys = join(",", array_keys($array));
        $vals = "'".join("','", array_values($array))."'";
        $sql = "insert into {$table} ($keys) values({$vals})";
        mysqli_query($link, $sql) or die("数据插入失败:".mysqli_errno($link).":".mysqli_error($link));

        return mysqli_insert_id($link);
    }

    /**
     * 更新记录操作
     * @param 表名 $table
     * @param 数据 $array
     * @param 数据库链接 $link
     * @param 数据库条件语句 $where
     */
    //数据库语句：update admin set username ='wong' where id = 1
    function update($table, $array, $link, $where=null){
        foreach ($array as $key=>$val){
            if ($str == null){
                $sep = "";
            }else {
                $sep = ",";
            }
            $str .= $sep.$key."='".$val."'";
        }
        $sql = "update {$table} set {$str} ".($where == null ? null : " where ".$where);
        $result = mysqli_query($link, $sql);

        if ($result) { //如果修改成功个返回数据
            return mysqli_affected_rows($link);
        }else{     //修改失败返回假
            return false; 
        }

    }

    /**
     * 删除记录
     * @param string $table
     * @param string $link
     * @param string $where
     * retrun number
     */
    function delete($table, $link, $where=null){
        $where = $where == null ? null : " where ".$where;
        $sql = "delete from {$table} {$where}";
        mysqli_query($link, $sql);

        return mysqli_affected_rows($link);
    }

    /**
     * 获取指定一条记录
     * @param string $sql
     * @param string $link
     * @param string $result_type
     * @return 
     */
    function fetchOne($sql, $link, $result_type=MYSQLI_ASSOC){
        $result = mysqli_query($link, $sql);
        // $row = mysqli_fetch_array($result,$result_type);
        if( mysqli_num_rows( $result )) 
            $row = mysqli_fetch_array($result,$result_type);    
        else 
            mysqli_error($link); 
        
        return $row;
    }

    /**
     * 获取所有记录
     * @param string $sql
     * @param string $link
     * @param string $result_type
     * @return Multitype
     */
    function fetchAll($sql, $link, $result_type=MYSQLI_ASSOC){
        $result = mysqli_query($link, $sql);
        $rows = '';
        while (@$row=mysqli_fetch_array($result)){
            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * 获取结果集记录条数
     * @param unknown $sql
     * @param unknown $link
     */
    function getResultNum($sql, $link){
        $result = mysqli_query($link, $sql);
        return mysqli_num_rows($result);
    }

    /**
     * 得到上一步插入记录的ID
     * @return [type] [description]
     */
    function getInsertId($link){
        return mysqli_insert_id($link);
    }