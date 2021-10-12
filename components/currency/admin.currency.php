<?php
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 
?>

<?php
require_once "inc/cb.php";
$res=mysql_query("SELECT * from ".$PREFIX."currency where id=1");
$row=mysql_fetch_row($res);
$eprice=$row[1];
$dprice=$row[2];
$ratio=$row[5];
$freq=$row[4]/3600;
$dcur="";$ecur="checked ";
if($row[3]=="dollar") {
    $dcur="checked ";$ecur="";
}
$lasttime=date("Hч:iмин. d-m-Y", $row[6]);
$dgruz=$ratio*$dprice;
$egruz=$ratio*$eprice;
if($_POST['update']) {
    $ratio=str_replace(",", ".", $_POST['ratio']);
    $freq=3600*$_POST['freq'];
    $currency=($_POST['curr']==2)?"dollar":"euro";
    mysql_query("update ".$PREFIX."currency set currency='$currency',freq='$freq',ratio='$ratio' where id=1");
}
?>
<form method="post">
<table>
<tr><td>Валюта</td><td>Евро <input type="radio" name="curr" value="1" <?php echo $ecur;?>/> Доллар <input type="radio" name="curr" value="2" <?php echo $dcur;?>/></td></tr>
<tr><td>Чатота обновления раз в</td><td><input type="text" name="freq" value="<?php echo $freq;?>" /> ч.</td></tr>
<tr><td>Курс Евро</td><td><input type="text" name="eprice" value="<?php echo $eprice;?>" size="6" READONLY /> ( <input type="text" name="egruz" value="<?php echo $egruz;?>" size="7" READONLY /> )</td></tr>
<tr><td>Курс Доллара</td><td><input type="text" name="dprice" value="<?php echo $dprice;?>" size="6" READONLY /> ( <input type="text" name="dgruz" value="<?php echo $dgruz;?>" size="7" READONLY /> )</td></tr>
<tr><td>Последний апдейт</td><td><input type="text" name="lasttime" value="<?php echo $lasttime;?>" READONLY /></td></tr>
<tr><td>Коэффициент</td><td><input type="text" name="ratio" value="<?php echo $ratio;?>" /></td></tr>
<tr><td></td><td><input type="submit" name="update" value="задать" /></td></tr>
</table>
</form>
