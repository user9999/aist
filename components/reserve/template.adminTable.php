<?php
$t=array('1'=>'Отменить бронь','2'=>'Удалить из базы','3'=>'Удалить из базы','4'=>'Удалить из базы');
if($TEMPLATE['action']<3) {
    $till=date("Hч. iмин. j M Y", ($TEMPLATE['add_date']+$TEMPLATE['RESERVE']*3600));
} elseif($TEMPLATE['action']==3) {
    $till="Отказ";
} else {
    $till="Отказано админом";
}
?>
<tr id="tr_<?php echo $TEMPLATE['id'] ?>" class='reserved'>
<td><?php echo $TEMPLATE['client'] ?></td>
<td><?php echo $TEMPLATE['name'] ?></td>
<td><?php echo $TEMPLATE['oem'] ?></td>
<td><?php echo $TEMPLATE['brandname'] ?> <br /> <?php echo $TEMPLATE['modelname'] ?></td>
<td><?php echo $TEMPLATE['description'] ?></td>
<td><?php echo $TEMPLATE['price'] ?>р.</td>
<td><?php echo $TEMPLATE['amount'] ?></td>
<td><?php echo ($TEMPLATE['special'])?$TEMPLATE['special']:"нет"; ?></td>

<td><?php echo $till ?></td>

<td><a href="?component=reserve&action=1&id=<?php echo $TEMPLATE['id'] ?>"><img src="/img/del.gif" title="<?php echo $t[$TEMPLATE['action']]?>" alt="" /></a></td>
</tr>
