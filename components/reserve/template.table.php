<tr id="tr_<?php echo $TEMPLATE['id'] ?>" class='reserved'>
<td><a href="catalog/item-<?php echo $TEMPLATE['itemid'] ?>&b=<?php echo $TEMPLATE['brandname'] ?>&t=<?php echo $TEMPLATE['modelname'] ?>"><?php echo $TEMPLATE['oem'] ?></a></td>
<td><?php echo $TEMPLATE['brandname'] ?> <br /> <a href="/catalog/model-<?php echo $TEMPLATE['model_id'] ?>"><?php echo $TEMPLATE['modelname'] ?></a></td>
<td><a href="catalog/item-<?php echo $TEMPLATE['itemid'] ?>&b=<?php echo $TEMPLATE['brandname'] ?>&t=<?php echo $TEMPLATE['modelname'] ?>"><?php echo $TEMPLATE['description']." (".$TEMPLATE['country'].")" ?></a></td>
<td><?php echo $TEMPLATE['price']." ".$GLOBALS['ZNAK'] ?></td>
<td><?php echo $TEMPLATE['amount'] ?></td>
<td style="text-align:center"><?php echo ($TEMPLATE['special'])?$TEMPLATE['special']:"нет"; ?></td>
<td><?php echo date("Hч. iмин. j M Y", ($TEMPLATE['add_date']+$TEMPLATE['RESERVE']*3600)) ?></td>
<td><a href="reserve/id-<?php echo $TEMPLATE['id'] ?>"><img src="/img/del.gif" title="Отменить бронь" alt="" /></a></td>
</tr>
