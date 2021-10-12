<?php $t=array("есть","нет","ожидается"); ?>
<tr id=tr_<?= $TEMPLATE['id'] ?> <?php
	$searchv = 1;
	if(!$_COOKIE['cart_item_id']){
	$_COOKIE['cart_item_id']=array();
	}
	if (in_array($TEMPLATE['id'], $_COOKIE['cart_item_id'])) {
		echo "class=ordered";
		$i = array_search($TEMPLATE['id'], $_COOKIE['cart_item_id']);
		$searchv = (int) $_COOKIE['cart_item_count'][$i];
	}
?>>
<?php
if(isset($TEMPLATE['sid']) && $TEMPLATE['sid']){ 
	$linkage="item-"; 
} else {
	$linkage="price-";
	$TEMPLATE['sid']=$TEMPLATE['id'];
}
?>
<?php if(!$TEMPLATE['showimg']){ ?>
<td><a href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $TEMPLATE['sid'] ?>&amp;b=<?= urlencode($TEMPLATE['btitle']) ?>&amp;t=<?= urlencode($TEMPLATE['ftitle']) ?>'><b><?= $TEMPLATE['oem'] ?></b></a></td>
<td><?php echo $TEMPLATE['btitle'] ?><br><?php if (!isset($TEMPLATE['mlinks'])) echo $TEMPLATE['ftitle']; else echo $TEMPLATE['model']; ?></td>
<?php } else { ?>
<td>
<?php
			$fl="";
			if(file_exists("uploaded/small_{$TEMPLATE['sid']}.jpeg")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['sid']}.jpeg";
			if(file_exists("uploaded/small_{$TEMPLATE['sid']}.png")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['sid']}.png";
			if(file_exists("uploaded/small_{$TEMPLATE['sid']}.gif")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['sid']}.gif";
			if($fl){
				echo "<a href='{$GLOBALS['PATH']}/catalog/".$linkage.$TEMPLATE['sid']."&amp;b=".urlencode($TEMPLATE['btitle'])."&amp;t=".urlencode($TEMPLATE['ftitle'])."'><img src='$fl' alt=''></a>";
			} else {
				echo "<a href='{$GLOBALS['PATH']}/catalog/".$linkage.$TEMPLATE['sid']."&amp;b=".urlencode($TEMPLATE['btitle'])."&amp;t=".urlencode($TEMPLATE['ftitle'])."'><img src='{$GLOBALS['PATH']}/img/small_nofoto.jpg' alt=''></a>";			
			}
?>
</td>
<td><a class=underlined href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $TEMPLATE['sid'] ?>&amp;b=<?= urlencode($TEMPLATE['btitle']) ?>&amp;t=<?= urlencode($TEMPLATE['ftitle']) ?>'><b><?= $TEMPLATE['oem'] ?></b></a></td>
<td><?php echo $TEMPLATE['btitle'] ?><br><?php if (!isset($TEMPLATE['mlinks'])) echo $TEMPLATE['ftitle']; else echo $TEMPLATE['model']; ?></td>
<?php } ?>
<td><a class=underlined href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $TEMPLATE['sid'] ?>&amp;b=<?= urlencode($TEMPLATE['btitle']) ?>&amp;t=<?= urlencode($TEMPLATE['ftitle']) ?>'><?= $TEMPLATE['description'] ?> <?= (strpos($_GET['id'], "plastic")!==false)?"(пластик)":"" ?><!--(<?= $TEMPLATE['country'] ?>)--></a>
<?php
	if($TEMPLATE['action']!=""){	
		echo "<br><a href=\"".$PATH."/static/special\" style=\"color:red;font-weight:bold\">Акция!!!</a>";
	}
?>	
</td>
<td class=rightal>
<?php 
		if($TEMPLATE['price']!=0){
			echo $TEMPLATE['price'] . " руб."; 
		} 
?>
</td>
<td>
<input style="width: 25px;" id="i<?= $TEMPLATE['id'] ?>" value="<?= $searchv ?>">
</td>
<td>
<?php 
		if($TEMPLATE['price']!= 0){
			echo " &nbsp; <a href='javascript:addToCart({$TEMPLATE['id']}, {$TEMPLATE['price']});'><img title='купить  {$TEMPLATE['description']}' alt='купить  {$TEMPLATE['description']}' src='" . $GLOBALS['PATH'] . "/templates/blank/img/cartadd.png'></a>";
		} 
?>			
</td>
</tr>