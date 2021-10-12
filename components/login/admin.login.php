<?php
if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 

if (isset($_SESSION['admin_name'])) { header("Location: $PATH/admin/?page=index");
}

//make login
$err = "";
//var_dump($_POST);
$_GET['component']=$_GET['component']??'index';
$url=($_GET['component'])?"?component=".$_GET['component']:"";
if (isset($_POST['admin_login']) && isset($_POST['admin_password'])) {
    $login=trim($_POST['admin_login']);
    $password=trim($_POST['admin_password']);
    if ($login == $ADMIN_LOGIN &&  $password == $ADMIN_PASSWORD) {
        $_SESSION['admin_name'] = $ADMIN_LOGIN;
        header("Location: $PATH/admin/".$url);
    } else { 
        $password=encrypt($password,$SECRET_KEY);
        $query="SELECT * FROM ".$PREFIX."admin_users WHERE login='{$login}' and password='{$password}'";
        echo $query;
        $result= mysql_query($query);
        if(mysql_num_rows($result)>0){
            $row = mysql_fetch_array($result);
            $_SESSION['admin_name'] = $login;
            $_SESSION['role'] = $row['role'];
            header("Location: $PATH/admin/".$url);
        }else{
            $err = "<b>Логин и/или пароль введены неверно.</b><br /><br />";
        }
    }
}

include($ADMIN_TEMPLATE.".login.php");
?>
