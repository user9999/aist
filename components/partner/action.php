<?php
session_start();
require_once "../../inc/configuration.php";
require_once "../../inc/functions.php";
if (!isset($_SESSION['admin_name'])) { die('no access');
}
$text='';$title='RE:';$rw='';
if($_GET['pblock']) {
    $text="Нарушения правил пользования партнерской программой";
    if($_POST['send']) {
        mysql_query('update partner_users set blok="'.addslashes($_POST['message']).'" where id='.$_GET['pblock']);
        $error="Отправлено";
        $text=$_POST['message'];
    }
    $text="Нарушения правил пользования партнерской программой";
    $rw=" READONLY ";
    $title="Блокировка";
}


if($_GET['un'] && $_GET['pmess']) {
    $text='Уважаемый '.urldecode($_GET['un']).",\r\n\r\n\r\n\r\n\r\n      Администратор.";
    $title='RE: Выплата';
    if($_POST['send']) {
        mysql_query('insert into partner_message set sender=0,title="'.addslashes($_POST['title']).'",message="'.addslashes($_POST['message']).'",messageid=0,recipient='.$_GET['pmess'].',sendtime='.time());
        $text=$_POST['message'];
        $title=$_POST['title'];
        $error="Сообщение отправлено!";
    }
}
if($_GET['un'] && $_GET['mid']) {
    $res=mysql_query('select sender,title from partner_message where id='.$_GET['mid']);
    $row=mysql_fetch_row($res);
    $title='RE:'.$row[1];
    $text='Уважаемый '.urldecode($_GET['un']).",\r\n\r\n\r\n\r\n\r\n      Администратор.";
    if($_POST['send']) {
        mysql_query('insert into partner_message set sender=0,title="'.addslashes($_POST['title']).'",message="'.addslashes($_POST['message']).'",messageid='.$_GET['mid'].',recipient='.$row[0].',sendtime='.time());
        mysql_query('update partner_message set status=2 where id='.$_GET['mid']);
        $text=$_POST['message'];
        $title=$_POST['title'];
        $error="Сообщение отправлено!";
    }

}
?>
<form method=post>
<p style='color:red'><?php echo $error?></p>
<table>
<tr><td>Заголовок</td><td><input name=title value="<?php echo $title?>"<?php echo $rw?>></td></tr>
<tr><td colspan=2><textarea name=message rows=18 cols=55><?php echo $text?></textarea></td></tr>
<tr><td></td><td><input type=submit name=send value="Отправить"></td></tr>
</table>
</form>
