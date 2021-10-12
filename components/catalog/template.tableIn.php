<?php $t = array("есть", "нет", "ожидается"); ?>

<tr id="tr_<?= $TEMPLATE['id'] ?>" <?php
	$searchv = 1;
	if ($_COOKIE['cart_item_id'] && in_array($TEMPLATE['id'], $_COOKIE['cart_item_id'])) {
		echo "class='ordered'";
		$i = array_search($TEMPLATE['id'], $_COOKIE['cart_item_id']);
		$searchv = (int) $_COOKIE['cart_item_count'][$i];
	}

?>>
	<?php
	//var_dump($TEMPLATE);
	
	//$farm_prod=substr($TEMPLATE['name'],0,3);
	if (isset($TEMPLATE['sid']) && $TEMPLATE['sid']) { 
		$linkage = "item-"; 
	} else {
		$linkage = "price-";
		$TEMPLATE['sid'] = $TEMPLATE['id'];
	}
	?>
	
	<?php if (!$TEMPLATE['showimg']) { ?>
		<td><a href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $TEMPLATE['sid'] ?>'><b><?= $TEMPLATE['oem'] ?></b></a></td><!--&amp;b=<?= urlencode($TEMPLATE['btitle']) ?>&amp;t=<?= urlencode($TEMPLATE['ftitle']) ?>-->
		<td><?php if (!isset($TEMPLATE['mlinks'])) echo $TEMPLATE['ftitle']; else echo $TEMPLATE['model']; ?></td>
	<?php } else { ?>
		<td>
			<?php
			$fl = "";
			if (file_exists("uploaded/small_{$TEMPLATE['sid']}.jpeg")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['sid']}.jpeg";
			if (file_exists("uploaded/small_{$TEMPLATE['sid']}.png")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['sid']}.png";
			if (file_exists("uploaded/small_{$TEMPLATE['sid']}.gif")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['sid']}.gif";
				
			if ($fl) {
				echo "<a href='{$GLOBALS['PATH']}/catalog/".$linkage.$TEMPLATE['sid']."'><img src='$fl' alt='{$TEMPLATE['description']}'></a>";//."&amp;b=".urlencode($TEMPLATE['btitle'])."&amp;t=".urlencode($TEMPLATE['ftitle'])."
			} else {
				echo "<a href='{$GLOBALS['PATH']}/catalog/".$linkage.$TEMPLATE['sid']."'><img src='{$GLOBALS['PATH']}/img/small_nofoto.jpg' alt=''></a>";//&amp;b=".urlencode($TEMPLATE['btitle'])."&amp;t=".urlencode($TEMPLATE['ftitle'])."	
			}
			?>
		</td>

	<?php } ?>
	<td><a class="underlined" href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $TEMPLATE['sid'] ?>'><?= $TEMPLATE['description'] ?></a>


<?php
	if ($TEMPLATE['action'] !="") {	
		echo "<br><a href=\"".$PATH."/static/special\" style=\"color:red;font-weight:bold\">Акция!!!</a>";
	}
?>	
	</td>
		<td class="centeral">
<a href="<?= $GLOBALS['PATH'] ?>/farms/<?= $TEMPLATE['farm'] ?>"><?= $TEMPLATE['country'] ?></a>
<?php
if($TEMPLATE['ftitle']){
?>
<br>
(<a href="<?= $GLOBALS['PATH'] ?>/catalog/farm-<?= $TEMPLATE['farm'] ?>">Вся продукция</a>)
<?php
}
?>
	</td>

	<td class="rightal">
		<?php 
		if ($TEMPLATE['price'] != 0) {
			echo $TEMPLATE['price'] . " руб. за ".$TEMPLATE['dimension']; 
		} 
		if (!$_COOKIE['cart_item_id']){
		$dimension=explode(" ",$TEMPLATE['dimension']);
		$searchv=str_replace(",",".",$dimension[0]);
		//$units=$dimension[1];
		}
		?>
	</td>
<?php if ($_GET['stat']!='archive') { ?>
	<td>
		<input style="width: 25px;" id="i<?= $TEMPLATE['id'] ?>" value="<?= $searchv ?>" tabindex=<?= ($TEMPLATE['tabindex']*2-1) ?>>
	</td>
	
	<td>
		<?php 
		if ($TEMPLATE['price'] != 0) {
			echo " &nbsp; <a href='javascript:addToCart({$TEMPLATE['id']}, {$TEMPLATE['price']}, \"$dimension[0]\");' tabindex=".($TEMPLATE['tabindex']*2)."><img title='купить  {$TEMPLATE['description']}' alt='купить  {$TEMPLATE['description']}' src='" . $GLOBALS['PATH'] . "/templates/blank/img/cartadd.png'></a>";
		} 
		?>			
	</td>
<?php } ?>

</tr>
