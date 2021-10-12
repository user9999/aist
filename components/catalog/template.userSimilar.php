<div class="content_body">
	<h3>Похожие товары</h3>
	<table width="100%" class="similar">
<tr id="tr_<?= $v['id'] ?>" <?php
	$searchv = 1;
	if (in_array($v['id'], $_COOKIE['cart_item_id'])) {
		echo "class='ordered'";
		$i = array_search($v['id'], $_COOKIE['cart_item_id']);
		$searchv = (int) $_COOKIE['cart_item_count'][$i];
	}
	?>>
			<?php $nn = 0; foreach ($TEMPLATE as $v) { ?>
				<!--<td valign="top" width="33%">-->
					<?php $nn++;
					if ($v['id']) {
						$linkage = "item-";
						//$pic=$v['id'];
						
					} else {
						$linkage = "price-";
						$v['id'] = $v['bid'];
					}
					
					if (isset($_GET['t'])) { 
						$_GET['t'] = ereg_replace("[^A-Za-zА-Яа-я0-9 -]","", $_GET['t']);
						$_GET['b'] = ereg_replace("[^A-Za-zА-Яа-я0-9 -]","", $_GET['b']);
						$v['modelname'] = $_GET['t'];
						$v['brandname'] = $_GET['b'];
					}
					?>
					
					
	<?php if (!$v['showimg']) { ?>
		<td><a href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $TEMPLATE['sid'] ?>'><b><?= $v['oem'] ?></b></a></td>
		<td><?php if (!isset($v['mlinks'])) echo $v['ftitle']; else echo $v['model']; ?></td>
	<?php } else { ?>
		<td>
			<?php
			$fl = "";
			if (file_exists("uploaded/small_{$v['id']}.jpeg")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$v['id']}.jpeg";
			if (file_exists("uploaded/small_{$v['id']}.png")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$v['id']}.png";
			if (file_exists("uploaded/small_{$v['id']}.gif")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$v['id']}.gif";
				
			if ($fl) {
				echo "<img src='$fl'>";
			}
			?>
		</td>
		<td><a class="underlined" href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $v['id'] ?>&b=<?= $v['brandname'] ?>&t=<?= $v['modelname'] ?>'><b><?= $v['oem'] ?></b></a></td>
		<td><?php echo $v['modelname'];//if (!isset($v['mlinks'])) echo $v['ftitle']; else echo $v['model']; ?></td>
	<?php } ?>
					
			<td><a class="underlined" href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $v['id'] ?>&b=<?= $v['brandname'] ?>&t=<?= $v['modelname'] ?>'><?= $v['description'] ?> (<?= $v['country'] ?>)</a>
<?php
	if ($v['action'] !="") {	
		echo "<br /><span style=\"color:red;font-weight:bold\">Акция!!!</span>";
	}
?>	
	</td>
	<!--<td class="centeral">
		<?= $t[$TEMPLATE['av']] ?>
	</td>-->
	<td class="rightal">
		<?php 
		if ($v['price'] != 0) {
			echo $v['price'] . " руб."; 
		} 
		?>
	</td>
	
	<?php if ($v['waitingfor']!='архив') { ?>
	<td>
		<input style="width: 25px;" id="i<?= $v['id'] ?>" value="<?= $searchv ?>" />
	</td>
	<td>
		<?php 
		if ($v['price'] != 0) {
			echo " &nbsp; <a href='javascript:addToCart({$v['bid']}, {$v['price']});'><img title='Добавление позиции' alt='Добавление позиции' src='" . $GLOBALS['PATH'] . "/templates/blank/img/cartadd.png' /></a>";
		} 
		?>			
	</td>		
<?php } ?>	
					
				<!--	<b><?= $v['brandname'] ?> <?= $v['modelname'] ?></b> <a href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $v['id'] ?>'><b><?= $v['description'] ?></b></a> <?= $v['country'] ?>
					<br /><br />
					<?php 
					if ($v['price'] != 0) {
						echo "<b>Цена: <span style=\"color: red;\">" . $v['price'] . " руб.</span></b>";
						echo " &nbsp; <a href='#' class='underlined' onclick='addToCart(" . $v['bid'] . ", " . $v['price'] . ");'>Добавить в корзину</a>";
						echo "<br />"; 
					} 
					?>
				</td>-->
				
			<?php } ?>
			
			<?php if (!$nn) { ?><td>Не найдено ни одной позиции.</td><?php } ?>
		</tr>
	</table>
</div>
