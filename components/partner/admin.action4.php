<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 
//$res=mysql_query('select a.*,max(b.cashsum) as cash from partner_users as a,partner_money as b where b.partnerid=a.id');
$res=mysql_query(
    '(select a.*,b.cashsum as cash from '.$PREFIX.'partner_users as a,'.$PREFIX.'partner_money as b where b.partnerid=a.id and b.cashsum>0) union (select '.$PREFIX.'partner_users.*,0 as cash FROM '.$PREFIX.'partner_users LEFT JOIN '.$PREFIX.'partner_money ON '.$PREFIX.'partner_users.id='.$PREFIX.'partner_money.partnerid
        WHERE '.$PREFIX.'partner_money.partnerid IS NULL)'
);
if(mysql_num_rows($res)) {
    $out='<table><tr class="hd"><td>ID</td><td>name</td><td>email</td><td>cash</td><td>заказы</td><td></td><td></td></tr>';
    while($row=mysql_fetch_array($res)){
        $orders='';
        $res1=mysql_query('select distinct order_id from '.$PREFIX.'partner_money where partnerid='.$row[0]);
        while($row1=mysql_fetch_row($res1)){
            $orders.='<a href="?component=order&order_id='.$row1[0].'">'.$row1[0].'</a>,';
        }
        $orders=substr($orders, 0, -1);
        $out.='<tr><td>'.$row[0].'</td><td>'.$row['name'].'</td><td>'.$row['email'].'</td><td>'.$row['cash'].'</td><td>'.$orders.'</td><td><a href="javascript: void(0)" onclick="window.open(\'/components/partner/action.php?pmess='.$row[0].'&un='.urlencode($row['name']).'\',\'mess\',\'width=480,height=400,top=0,left=0\')">Сообщение</a><br><a href="javascript: void(0)" onclick="window.open(\'/components/partner/action.php?pblock='.$row[0].'&un='.urlencode($row['name']).'\',\'block\',\'width=480,height=400,top=0,left=0\')">Блокировка</a></td>
  <td><a href="?component=partner&action=4&enter='.$row[0].'">Войти</a></td></tr>';
    }
    $out.="</table>";
}
if($_GET['enter']) {
    unset($_SESSION['partnerid']);
    $_SESSION['partnerid']=$_GET['enter'];
    header('Location: '.$GLOBALS[PATH].'/account');
}
?>
<br><br>
<h1>Партнеры</h1>

<?php echo $out?>
