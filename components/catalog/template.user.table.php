<?php $t = array("есть", "нет", "ожидается"); ?>

<tr id="tr_<?= $TEMPLATE['id'] ?>" <?php
	$searchv = 1;
	if (in_array($TEMPLATE['id'], $_COOKIE['cart_item_id'])) {
		echo "class='ordered'";
		$i = array_search($TEMPLATE['id'], $_COOKIE['cart_item_id']);
		$searchv = (int) $_COOKIE['cart_item_count'][$i];
	}

?>>
	<?php
	//var_dump($TEMPLATE);
	if (isset($TEMPLATE['sid']) && $TEMPLATE['sid']) { 
		$linkage = "item-"; 
	} else {
		$linkage = "price-";
		$TEMPLATE['sid'] = $TEMPLATE['id'];
	}
	?>
	
	<?php if (!$TEMPLATE['showimg']) { ?>
		<td><a href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $TEMPLATE['sid'] ?>'><b><?= $TEMPLATE['oem'] ?></b></a></td>
		<td><?php if (!isset($TEMPLATE['mlinks'])) echo $TEMPLATE['ftitle']; else echo $TEMPLATE['model']; ?></td>
	<?php } else { ?>
		<td>
			<?php
			$fl = "";
			if (file_exists("uploaded/small_{$TEMPLATE['sid']}.jpeg")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['sid']}.jpeg";
			if (file_exists("uploaded/small_{$TEMPLATE['sid']}.png")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['sid']}.png";
			if (file_exists("uploaded/small_{$TEMPLATE['sid']}.gif")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['sid']}.gif";
				
			if ($fl) {
				echo "<img src='$fl'>";
			}
			?>
		</td>
		<td><a class="underlined" href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $TEMPLATE['sid'] ?>&b=<?= $TEMPLATE['btitle'] ?>&t=<?= $TEMPLATE['ftitle'] ?>'><b><?= $TEMPLATE['oem'] ?></b></a></td>
		<td><?php if (!isset($TEMPLATE['mlinks'])) echo $TEMPLATE['ftitle']; else echo $TEMPLATE['model']; ?></td>
	<?php } ?>
	<td><a class="underlined" href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $TEMPLATE['sid'] ?>&b=<?= $TEMPLATE['btitle'] ?>&t=<?= $TEMPLATE['ftitle'] ?>'><?= $TEMPLATE['description'] ?> (<?= $TEMPLATE['country'] ?>)</a>
<?php
	if ($TEMPLATE['action'] !="") {	
		echo "<br /><a href=\"".$PATH."/static/special\" style=\"color:red;font-weight:bold\">Акция!!!</a>";
	}
?>	
	</td>
<?php
if($TEMPLATE['city']){
?>
<td class="centeral">
<?= $TEMPLATE['spb'] ?>
</td>
<td class="centeral">
<?= $TEMPLATE['msk'] ?>
</td>
<?php
} else {
?>
<td class="centeral">
<?= $t[$TEMPLATE['av']] ?>
</td>
<?php
}
?>
	<td class="rightal">
		<?php 
		if ($TEMPLATE['price'] != 0) {
			echo $TEMPLATE['price'] . " ".$GLOBALS['ZNAK']; 
		} 
		?>
	</td>
	
	<td>
	<a href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $TEMPLATE['sid'] ?>'><img title='купить <?= $TEMPLATE['description'] ?>' alt='купить <?= $TEMPLATE['description'] ?>' src='<?=  $GLOBALS['PATH'] ?>/templates/blank/img/cartadd.png' /></a>
	</td>
</tr>
