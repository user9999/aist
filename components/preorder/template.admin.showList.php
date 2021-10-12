<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 
if($TEMPLATE['utype']==2) { $color="background:#9f9";
}
if($TEMPLATE['utype']==1) { $color="background:#ffa";
}
if($TEMPLATE['user_id']!="0") {
    $user="<a href=\"/admin/?component=users&action=1&edit=".$TEMPLATE['user_id']."\" target=\"_blank\">".$TEMPLATE['name']."</a>";
} else {
    $user=$TEMPLATE['name'];
}
$editorder=($TEMPLATE['action']=="delete")?"del":"ok";
?>
<?php
if($_GET['action']==2 && $TEMPLATE['num']==1) {
    $from=($_POST['fromdate'])?$_POST['fromdate']:date("d.m.Y", (time()-60*60*24*30));
    $till=($_POST['tilldate'])?$_POST['tilldate']:date("d.m.Y", time());
    ?>
<div style="width:100%;height:auto;">
<form name="main" method="post">
От: <input name="fromdate" value="<?php echo $from ?>" type="text"><img onclick="popUpCalendar(this, main.fromdate, 'dd.mm.yyyy');" src="/img/date_selector.gif" border="0" height="18" hspace="3" width="16">
До: <input name="tilldate" value="<?php echo $till ?>" type="text"><img onclick="popUpCalendar(this, main.tilldate, 'dd.mm.yyyy');" src="/img/date_selector.gif" border="0" height="18" hspace="3" width="16">
<input type="submit" name="show" value="Показать" />
</form>
</div>
    <?php
}
?>
<div style="width:100%;height:auto;<?php echo $color?>">
<h3>Заказ №<?php echo $TEMPLATE['id'] ?> от <?php echo date('d.m.Y H:i', $TEMPLATE['order_date']) ?> <a href="?component=preorder&<?php echo $editorder ?>_id=<?php echo $TEMPLATE['id'] ?>">Удалить</a></h3><br />
<b>Заказчик:</b> <?php echo $user ?> &nbsp; <b>E-mail:</b> <?php echo $TEMPLATE['email'] ?><br />
<b>Сумма заказа:</b> <?php echo $TEMPLATE['price'] ?> руб. (<?php echo $TEMPLATE['amount'] ?> шт.)<br />
<a href="?component=preorder&orderid=<?php echo $TEMPLATE['id'] ?>">Подробнее о заказе</a> <a href="javascript: void(0)" onclick="window.open('/csv.php?preorder_id=<?php echo $TEMPLATE['id'] ?>','csv','width=0,height=0,top=0,left=0,resize=0');return false" style="display:block;float:right;margin-right:7px"><img src="/img/csv.png" alt="" style="display:block;float:left" /> CSV</a>
<a href="javascript: void(0)" onclick="window.open('/xls.php?preorder_id=<?php echo $TEMPLATE['id'] ?>','csv','width=0,height=0,top=0,left=0,resize=0');return false" style="display:block;float:right;margin-right:7px"><img src="/img/csv.png" alt="" style="display:block;float:left" /> XLS</a>
</div>
<hr>
