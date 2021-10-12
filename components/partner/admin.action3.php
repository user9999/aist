<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
}
if($_GET['uid']) {
    unset($_SESSION['partnerid']);
    unset($_SESSION['pname']);
    $_SESSION['partnerid']=$_GET['uid'];
    $_SESSION['pname']=$_GET['pname'];
    header("Location: $PATH/account");
}
if($_GET['payid']) {
    mysql_query('update '.$PREFIX.'partner_withdraw set paytime='.time().' where id='.$_GET['payid']);
}
$res=mysql_query('select a.id,a.partnerid,a.cash,a.paysys,a.number,a.ordertime,a.confirmtime,b.name,b.email from '.$PREFIX.'partner_withdraw as a, '.$PREFIX.'partner_users as b where b.id=a.partnerid and a.confirm="" and a.paytime=0');
if(mysql_num_rows($res)) {
    $topay='<table><tr><td style="width:70px">Партнер</td><td style="width:70px">Сумма</td><td style="width:80px">Платеж</td><td style="width:100px">Счет</td><td style="width:90px">Заказано</td><td style="width:90px">Подтверждено</td><td>Действие</td></tr>';
    while($row=mysql_fetch_row($res)){
        $topay.='<tr><td><a href="?component=partner&action=3&uid='.$row[1].'&pname='.$row[7].'" title='.$row[1].'>'.$row[7].'</a></td><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[4].'</td><td>'.date("H:i:s", $row[5]).'<br>'.date("d-m-Y", $row[5]).'</td><td>'.date("H:i:s", $row[6]).'<br>'.date("d-m-Y", $row[6]).'</td><td><a href="?component=partner&action=3&payid='.$row[0].'">Оплачено</a><br><a href="javascript: void(0)" onclick="window.open(\'/components/partner/action.php?pmess='.$row[1].'&un='.urlencode($row[7]).'\',\'mess\',\'width=480,height=400,top=0,left=0\')">Сообщение</a><br><a href="javascript: void(0)" onclick="window.open(\'/components/partner/action.php?pblock='.$row[1].'&un='.urlencode($row[7]).'\',\'block\',\'width=480,height=400,top=0,left=0\')">Блокировка</a></td></tr>';
    }
    $topay.="</table>";
} else {
    $topay="Нет заказов на выплату";
}
$res=mysql_query('SELECT sum(cashsum) FROM `'.$PREFIX.'partner_money` where cashsum>0');
$row=mysql_fetch_row($res);
$cash=($row[0])?$row[0]:'0.00';
$cash="<br> На данный момент на аккаунтах партнеров сумма: ".$cash." руб.";
?>
<br><br>
<h1>Выплаты</h1>
<?php echo $topay?>
<?php echo $cash?>
