<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 
$r="";
if($TEMPLATE['order']['currency']!='') {
    $r="<td>Валюта</td><td>Курс</td><td>Коэф-т</td>";
}
?>
<h1>Информация о заказе №<?php echo $TEMPLATE['order']['id'] ?></h1>
<b>Заказчик:</b><br />
<?php echo $TEMPLATE['order']['name'] ?><br />
<br />
<b>Телефон:</b><br />
<?php echo $TEMPLATE['order']['phone'] ?><br />
<br />
<b>E-mail:</b><br />
<?php echo $TEMPLATE['order']['email'] ?><br />
<br />
<b>Адрес:</b><br />
<?php echo $TEMPLATE['order']['address'] ?><br />
<br />
<b>Дата и время заказа:</b><br />
<?php echo date("d.m.Y H:i", $TEMPLATE['order']['date']) ?><br />
<br />
<h1>Заказанные позиции</h1>
<table style="font-size:10px;background:#eee"><tr style="background:#ccc"><td>№</td><td>Uniq ID</td><td>размерность</td><td>название</td><td>Кол-во(цена)</td><td>акция</td><?php echo $r ?><td></td></tr>
<?php
//var_dump($TEMPLATE['order']);
$sum = 0;
//var_dump($TEMPLATE);
//echo $TEMPLATE["utype"]."--<br>";
$qv=0;$yesum=0;$num=0;
foreach ($TEMPLATE['items'] as $v) {
    $num++;
    if($TEMPLATE['order']['currency']!='') {
        $yesum+=$v['quantity']*$v['price'];
        $znak=($TEMPLATE['order']['currency']=='euro')?"&euro;":"\$";
        $rd="<td>{$v['quantity']} шт по {$v['price']} $znak</td><td>{$TEMPLATE['order']['exrate']}</td><td>{$TEMPLATE['order']['ratio']}</td>";
        $v['price']=floor($v['price']*$TEMPLATE['order']['exrate']*$TEMPLATE['order']['ratio']);
        //$sum += (floor($v['price']*$TEMPLATE['order']['exrate']*$TEMPLATE['order']['ratio']))*$v['quantity'];
        $qv+=$v['quantity'];
        $sum+=$v['price']*$v['quantity'];
        //$tab="<tr><td></td><td></td><td></td><td>$qv шт. на сумму $sum руб.</td><td></td><td>$qv шт. на сумму $yesum $znak</td><td></td><td></td></tr>";
    } else {
        $qv+=$v['quantity'];
        $sum += $v['price'] * $v['quantity'];
        //$tab="<tr><td></td><td></td><td></td><td>$qv шт. на сумму $sum руб.</td><td></td><td></td></tr>";
    }
    $units=explode(" ", $v['provider']);
    $units[0]=str_replace(",", ".", $units[0]);
    $amount=$v['quantity']*$units[0];
    //$sum += $v['price'] * $v['quantity'];
    if($TEMPLATE['order']['utype']=="1") {
        $payed=($v['payed']==1)?"<span style=\"color:#999\">оплачено</span>":"<a href='?component=order&order_id=".$_GET['order_id']."&item_id={$v['id']}'>оплачено</a>";
    }
    echo "<tr><td>$num</td><td>{$v['name']}</td><td>{$v['provider']} </td><td>{$v['description']} </td><td>({$amount} {$units[1]} по {$v['price']} руб/{$v['provider']}) =".($v['price']*$v['quantity'])." руб</td><td><u><b>{$v['action']}</b></u></td>$rd<td><a target='_blank' href='?component=price&action=1&edit={$v['item_id']}'>просмотр</a> $payed<td></tr>";
}
$tab=($yesum==0)?"<tr><td></td><td></td><td></td><td></td><td>$qv шт. на сумму $sum руб.</td><td></td><td></td></tr>":"<tr><td></td><td></td><td></td><td></td><td>$qv шт. на сумму $sum руб.</td><td></td><td>$qv шт. на сумму $yesum $znak</td><td></td><td></td></tr>";
echo $tab;
?>
</table>
<br /><br />
Обратите внимание! В списке заказанных позиций отображается актуальная цена и название на момент осуществления заказа. При нажатии же ссылки "просмотр" будет показана текущая информация о позиции.<br />
<a href="javascript:history.go(-1);">Вернуться назад</a>
