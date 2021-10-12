<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
}
if($_POST['change']) {
    $percent1=str_replace(",", ".", $_POST['percent1']);
    $percent2=str_replace(",", ".", $_POST['percent2']);
    $sign = array(" ", ",", ".");
    $client=str_replace($sign, "", $_POST['client']);
    mysql_query('update '.$PREFIX.'partner_rules set percent1='.$percent1.',percent2='.$percent2.',minimum='.$_POST['minimum'].',withdraw="'.$_POST['withdraw'].'",email="'.$_POST['email'].'",client='.$client.' where id=1');
}
$res=mysql_query('select percent1,percent2,minimum,withdraw,email,client from '.$PREFIX.'partner_rules where id=1');
$row=mysql_fetch_row($res);
?>
<br><br>
<h1>Настройки</h1>
<form method=post>
<table>
<tr><td>Партнерский процент</td><td><input name=percent1 value="<?php echo $row[0] ?>"> %</td></tr>
<tr><td>Процент на акции</td><td><input name=percent2 value="<?php echo $row[1] ?>"> %</td></tr>
<tr><td>Максимальная сумма клиента</td><td><input name=client value="<?php echo $row[5] ?>"> руб.</td></tr>
<tr><td>Минимум к выплате</td><td><input name=minimum value="<?php echo $row[2] ?>"> руб.</td></tr>
<tr><td>Выплаты через</td><td><input name=withdraw value="<?php echo $row[3] ?>" size=50></td></tr>
<tr><td>Email для оповещения о выплатах</td><td><input name=email value="<?php echo $row[4] ?>" size=50></td></tr>
<tr><td></td><td><input type=submit name=change value="Изменить"></td></tr>
<tr><td></td><td></td></tr>
</table>
</form>
