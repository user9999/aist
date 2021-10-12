<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
if (isset($_SESSION['user_name'])) { header("Location: $PATH/index");
}
//make login
$err = "";
if (isset($_POST['user_login']) && isset($_POST['user_password'])) {
    $res=mysql_query("select id,name,phone,email,address from ".$PREFIX."users where email='".mysql_real_escape_string($_POST['user_login'])."' and password='".md5($_POST['user_password'])."' limit 1");
    if (mysql_num_rows($res)==1) {
        $row=mysql_fetch_row($res);

        $_SESSION['userid'] = $row[0];
        $_SESSION['user_name'] = $row[1];
        $_SESSION['phone'] = $row[2];
        $_SESSION['email'] = $row[3];
        $_SESSION['address'] = $row[4];


        header("Location: $PATH/profile");
        //$err ="<b>Добро пожаловать ".$row[1].". Вход выполнен успешно!</b><br /><br />";
    } else { $err = "<b>Логин и/или пароль введены неверно.</b><br /><br />";
    }
}
//include("template.welcome.php");
?>
