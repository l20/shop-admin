    <?php
    require_once '../include.php';

    $autoFlag = '0';
//         获取表单数据
    $username = $_POST['username'];
    $password = md5($_POST['password']);//md5加密
    $autoFlag = $_POST['autoFlag'];
    $verify = $_POST['verify'];
    $verify1 = $_SESSION['verify'];

    // echo "<script>alert('{$autoFlag}');</script>";

    //判断验证码是否正确
    if ($verify == $verify1){
        $sql = "select * from admin where username='{$username}' and password='{$password}'";
        $row = checkAdmin($sql, $link);
        if ($row){
            // 如果勾选了“一周内自动登录”
            if ($autoFlag) {
                setcookie("adminId", $row['id'], time()+7*24*3600);
                setcookie("adminName", $row['username'], time()+7*24*3600);
            }
            $_SESSION['adminName'] = $row['username'];
            $_SESSION['adminId'] = $row['id'];
            // header("location:index.php")
            alertMes("登陆成功。","index.php");
        } else{
            alertMes("登录失败，重新登录。","login.php");
        }
    }else{
            alertMes("验证码错误","login.php");
    }