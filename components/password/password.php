<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
$error="";
if (isset($_SESSION['user_name'])) {
    if($_POST['passwort']==$_POST['passwort1'] && strlen($_POST['passwort'])>4 && strlen($_POST['oldpass'])>3) {
        $res=mysql_query("select name from ".$PREFIX."users where password='".md5($_POST['oldpass'])."' and id='".$_SESSION['userid']."'");
        if(mysql_num_rows($res)==1) {
            mysql_query("update ".$PREFIX."users set password='".md5($_POST['passwort'])."' where id='".$_SESSION['userid']."'");
            $error="<h3 style=\"text-align:center;color:red;font-size:14px\">Новый пароль сохранен!</h3>";
        } else {
            $error="<h3 style=\"text-align:center;color:red;font-size:14px\">Ошибка: Неверный пароль!</h3>";
        }
    } elseif($_POST) {
        $error="<h3 style=\"text-align:center;color:red;font-size:14px\">Ошибка: Новые пароли не совпадают, либо длина пароля менее 5 символов!</h3>";
    }
    echo $error;
    ?>

<form method="post"><table style="margin:auto;margin-top:100px"><caption>Смена пароля</caption>

<tr class="title"><td>Смена </td><td>Данных</td></tr>



<tr><td>Текущий пароль</td><td><input type="password" name="oldpass" value="" /></td></tr>

<tr class="title"><td>&nbsp;</td><td></td></tr>



<tr><td>Новый пароль не менее 5 символов</td><td><input type="password" name="passwort" value="" /></td></tr>

<tr><td>Новый пароль еще раз</td><td><input type="password" name="passwort1" value="" /></td></tr>

<tr><td></td><td><input type="submit" name="ch_pass" value="изменить" class="button" /></td></tr> 
</table> 
</form>


    <?php
} else {
    header("Location:/error");
}
?>
