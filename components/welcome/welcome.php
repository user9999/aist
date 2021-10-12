<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
if (isset($_SESSION['user_name'])) { header("Location: $PATH/index");
}
//make login
$err = "";
if (isset($_POST['user_login']) && isset($_POST['user_password'])) {
    $res=mysql_query("select id,name,percent,actype,money from ".$GLOBALS['PREFIX']."users where email='".mysql_real_escape_string($_POST['user_login'])."' and password='".md5($_POST['user_password'])."' limit 1");
    //echo "select name,percent,actype from ".$GLOBALS['PREFIX']."users where email='".mysql_real_escape_string($_POST['user_login'])."' and password='".md5($_POST['user_password'])."' limit 1";
    if (mysql_num_rows($res)==1) {
        $row=mysql_fetch_row($res);
        //echo $row[3];
        if($row[3][2]!=1) {
            include_once "inc/users.configuration.php";
            $uper=0;
            foreach($PERCENTS as $sum=>$percent){
                if(floor($row[4])>$sum) {
                    $uper=$percent;
                }
            }
        } else {
            $uper=$row[2];
        }
        $_SESSION['userid'] = $row[0];
        $_SESSION['user_name'] = $row[1];
        $_SESSION['actype'] = $row[3];
        //$_SESSION['reserve'] = $row[3][1];
        $_SESSION['percent'] = $uper;
        $_SESSION['storage'] = $row[5];
        if($_SESSION['actype'][0]==1) {
            $row[6]=($row[6]<$row[7])?$row[7]:$row[6];
        }
        if($row[6]>1318505860) {
            //echo "here ".date("Hч. iмин. d.m.Y",$row[6]);
            $_SESSION['update']=date("Hч. iмин. d.m.Y", $row[6]);
        } else {
            include_once "inc/update.php";
            $_SESSION['update']=$PRICEUPDATE;
        }
        //echo $row[6]." ".$_SESSION['update'];
        //die();
        if($uper!=$row[2]) {
            mysql_query("update ".$PREFIX."users set percent=$uper where id='".$row[0]."'");
        }
        header("Location: $PATH/index");
        //$err ="<b>Добро пожаловать ".$row[1].". Вход выполнен успешно!</b><br /><br />";
    } else { $err = "<b>Логин и/или пароль введены неверно.</b><br /><br />";
    }
}
require "template.welcome.php";
?>
