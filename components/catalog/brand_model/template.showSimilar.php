<div class=content_body>
<h3>Похожие товары</h3>
<table width="100%" class=similar>
<?php $nn = 0; foreach ($TEMPLATE as $v) { ?>
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
<tr id=tr_<?= $v['id'] ?>	
<?php
$_COOKIE['cart_item_id']=($_COOKIE['cart_item_id'])?$_COOKIE['cart_item_id']:array();
	$searchv = 1;
	if (in_array($v['id'], $_COOKIE['cart_item_id'])) {
		echo "class=ordered";
		$i = array_search($v['id'], $_COOKIE['cart_item_id']);
		$searchv = (int) $_COOKIE['cart_item_count'][$i];
	}
?>>		
<?php if(!$v['showimg']){ ?>
<td><a href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $TEMPLATE['sid'] ?>&amp;b=<?= urlencode($v['brandname']) ?>&amp;t=<?= urlencode($v['modelname']) ?>'><b><?= $v['oem'] ?></b></a></td>
<td><?php if (!isset($v['mlinks'])) echo $v['ftitle']; else echo $v['model']; ?></td>
<?php } else { ?>
<td>
<?php
			$fl = "";
			if (file_exists("uploaded/small_{$v['id']}.jpeg")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$v['id']}.jpeg";
			if (file_exists("uploaded/small_{$v['id']}.png")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$v['id']}.png";
			if (file_exists("uploaded/small_{$v['id']}.gif")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$v['id']}.gif";
				
			if ($fl) {
				echo "<img src='$fl' alt=''>";
			}
			?>
</td>
<td><a class=underlined href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $v['id'] ?>&amp;b=<?= urlencode($v['brandname']) ?>&amp;t=<?= urlencode($v['modelname']) ?>'><b><?= $v['oem'] ?></b></a></td>
<td><?php echo $v['modelname'];//if (!isset($v['mlinks'])) echo $v['ftitle']; else echo $v['model']; ?></td>
<?php } ?>		
<td><a class=underlined href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $v['id'] ?>&amp;b=<?= urlencode($v['brandname']) ?>&amp;t=<?= urlencode($v['modelname']) ?>'><?= $v['description'] ?> (<?= $v['country'] ?>)</a>
<?php
	if ($v['action'] !="") {	
		echo "<br><span style=\"color:red;font-weight:bold\">Акция!!!</span>";
	}
?>	
</td>
<td class=rightal>
<?php 
		if ($v['price'] != 0) {
			echo $v['price'] . " руб."; 
		} 
?>
</td>
<?php if($v['waitingfor']!='архив'){ ?>
<td>
<input style="width: 25px;" id=i<?= $v['id'] ?> value="<?= $searchv ?>">
</td>
<td>
<?php 
		if($v['price']!=0){
		$buydesc=trim(str_replace("(метал)","",$v['description']));
			echo " &nbsp; <a href='javascript:addToCart({$v['bid']}, {$v['price']});'><img title='купить $buydesc {$v['brandname']}' alt='купить $buydesc {$v['brandname']}' src='" . $GLOBALS['PATH'] . "/templates/blank/img/cartadd.png'></a>";
		} 
?>			
	</td>		
<?php } ?>
</tr>				
<?php } ?>
<?php if(!$nn){ ?><tr><td>Не найдено ни одной позиции.</td></tr><?php } ?>
</table>
</div>