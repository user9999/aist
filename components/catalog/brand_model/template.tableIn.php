<?php $t=array("есть","нет","ожидается"); ?>
<?php
$script="<script type=\"text/javascript\">
function sub(el) {
  img=document.getElementById('img_'+el);
  el=document.getElementById('sub_'+el);
  if(el.style.display == 'none'){
    el.style.display = '';
    img.setAttribute('src', '".$GLOBALS['PATH'] . "/img/up.png');
  } else {
    el.style.display = 'none';
    img.setAttribute('src', '".$GLOBALS['PATH'] . "/img/down.png');
  }
}
</script>";
set_script($script);
//var_dump($TEMPLATE['material']);
$material="";
if(is_string($TEMPLATE['material'])){
$material=substr($TEMPLATE['material'],strpos($TEMPLATE['material'],"Материал"));
$material=substr($material,0,strpos($material,"."));
}



if(is_array($TEMPLATE['id'])){
$pr_array=$TEMPLATE['price'];
arsort($pr_array);
$end = array_shift($pr_array);
$begin=array_pop ($pr_array);
$prices=$begin."руб. до ".$end."руб.";
$pic=$TEMPLATE['sid'][0];
$tid=$TEMPLATE['id'][0];
//echo $pic."<br>";
foreach($TEMPLATE['sid'] as $s=>$f){
  if($TEMPLATE['country'][$s]=='Тайвань'){
    $pic=$TEMPLATE['sid'][$s];
	//echo $pic."<br>";
    break;
  }
}
?>


<!--begin-->
<tr id=t_<?= $tid ?> <?php
	$searchv = 1;
	$_COOKIE['cart_item_id']=($_COOKIE['cart_item_id'])?$_COOKIE['cart_item_id']:array();
	//if(in_array($TEMPLATE['id'][0], $_COOKIE['cart_item_id'])) {
    if(array_intersect ( $TEMPLATE['id'], $_COOKIE['cart_item_id'])){
		echo "class=ordered";
		$i = array_search($TEMPLATE['id'][0], $_COOKIE['cart_item_id']);
		$searchv = (int) $_COOKIE['cart_item_count'][$i];
	}
?>>
<?php
if(isset($TEMPLATE['sid'][0]) && $TEMPLATE['sid'][0]){ 
	$linkage="item-"; 
} else {
	$linkage="price-";
	$TEMPLATE['sid'][0]=$TEMPLATE['id'][0];
}
?>
<?php if(!$TEMPLATE['showimg'][0]){ ?>
<td><a href='javascript:sub("<?= $TEMPLATE['id'][0] ?>")'><b><?= $TEMPLATE['oem'][0] ?></b></a></td>
<td><?php if(!isset($TEMPLATE['mlinks'][0])) echo $TEMPLATE['ftitle'][0]; else echo $TEMPLATE['model'][0]; ?></td>
<?php } else { ?>
<td>
<?php
			$fl="";
			if(file_exists("/home/users/g/gruz-zap88/domains/custom-truck.ru/uploaded/small_{$pic}.jpeg")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$pic}.jpeg";
			if(file_exists("/home/users/g/gruz-zap88/domains/custom-truck.ru/uploaded/small_{$pic}.png")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$pic}.png";
			if(file_exists("/home/users/g/gruz-zap88/domains/custom-truck.ru/uploaded/small_{$pic}.gif")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$pic}.gif";
			if($fl){
				echo "<a href='javascript:sub(\"".$TEMPLATE['id'][0]."\")' title='увеличить'><img src='$fl' alt='".$TEMPLATE['description'][0]."'></a>";
			} else {
				echo "<a href='javascript:sub(\"".$TEMPLATE['id'][0]."\")'><img src='{$GLOBALS['PATH']}/img/small_nofoto.jpg' alt=''></a>";			
			}
			?>
</td>
<td><a class=underlined href='javascript:sub("<?= $TEMPLATE['id'][0] ?>")'><b><?= $TEMPLATE['oem'][0] ?></b></a></td>
<td><?php if (!isset($TEMPLATE['mlinks'][0])) echo $TEMPLATE['ftitle'][0]; else echo $TEMPLATE['model'][0]; ?></td>
<?php } ?>
<td><a class=underlined href='javascript:sub("<?= $TEMPLATE['id'][0] ?>")'><?= $TEMPLATE['description'][0] ?></a>
<?php
if($TEMPLATE['action'][0]!=""){	
	echo "<br><a href=\"".$PATH."/static/special\" style=\"color:red;font-weight:bold\">Акция!!!</a>";
}
?>	
</td>
<td class=rightal style="font-size:10px">
<?php 
if($TEMPLATE['price'][0]!=0){
  //if($TEMPLATE['nextprice']>$TEMPLATE['price']){
	//echo $TEMPLATE['price']."руб. *** ".$TEMPLATE['nextprice']."руб.";
	//} elseif($TEMPLATE['nextprice']<$TEMPLATE['price']){
	//echo $TEMPLATE['nextprice']."руб. *** ".$TEMPLATE['price']."руб.";
	//} else {
	echo $prices;
	//}
} 
?>
</td>
<?php if($_GET['stat']!='archive'){ ?>
<td>
<input style="width:25px;" value="<?= $searchv ?>" tabindex=<?= ($TEMPLATE['tabindex'][0]*2-1) ?>>
</td>
<td>
<?php 

	echo " &nbsp; <a href='javascript:sub(\"".$TEMPLATE['id'][0]."\")' tabindex=".($TEMPLATE['tabindex'][0]*2)."><img id='img_".$TEMPLATE['id'][0]."' title='показать  {$TEMPLATE['description'][0]}' alt='показать  {$TEMPLATE['description'][0]}' src='" . $GLOBALS['PATH'] . "/img/down.png'></a>";

?>			
</td>
<?php }
?>
</tr>


<tr id=sub_<?= $TEMPLATE['id'][0] ?> style='display:none'><td colspan=7 style="padding:10px 0 30px 30px"><!--style='display:none'-->

<fieldset style="width:95%;background:url('<?= $GLOBALS['IMGPATH'].'/templates/blank/img/fon.jpg' ?>') repeat-x">
<table style="width:100%">
<tr class="hd" style="font-weight:bold"><td>Фото</td><td>Произв-ль</td><td>Наличие</td><td>Цена</td><td>Заказ шт.</td><td style="width:8%">В корзину</td></tr>

<!--sub-->

<!--td style="width:30%">Материал</td-->
<?php
foreach($TEMPLATE['id'] as $n=>$id){
?>

<tr id=tr_<?= $TEMPLATE['id'][$n] ?> <?php
	$searchv = 1;

	if(in_array($id, $_COOKIE['cart_item_id'])) {
		echo "class=ordered";
		$i = array_search($id, $_COOKIE['cart_item_id']);
		$searchv = (int) $_COOKIE['cart_item_count'][$i];
	} ?>><td>
<?php
//echo $n."--";
			$fl="";
			if(file_exists("/home/users/g/gruz-zap88/domains/custom-truck.ru/uploaded/small_{$TEMPLATE['sid'][$n]}.jpeg")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['sid'][$n]}.jpeg";
			if(file_exists("/home/users/g/gruz-zap88/domains/custom-truck.ru/uploaded/small_{$TEMPLATE['sid'][$n]}.png")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['sid'][$n]}.png";
			if(file_exists("/home/users/g/gruz-zap88/domains/custom-truck.ru/uploaded/small_{$TEMPLATE['sid'][$n]}.gif")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['sid'][$n]}.gif";
			if($fl){
				echo "<a href='{$GLOBALS['PATH']}/catalog/".$linkage.$TEMPLATE['sid'][$n]."&amp;b=".urlencode($TEMPLATE['btitle'][$n])."&amp;t=".urlencode($TEMPLATE['ftitle'][$n])."' title='увеличить'><img src='$fl' alt='".$TEMPLATE['description'][$n]."'></a>";
			} else {
				echo "<a href='{$GLOBALS['PATH']}/catalog/".$linkage.$TEMPLATE['sid'][$n]."&amp;b=".urlencode($TEMPLATE['btitle'][$n])."&amp;t=".urlencode($TEMPLATE['ftitle'][$n])."'><img src='{$GLOBALS['PATH']}/img/small_nofoto.jpg' alt=''></a>";			
			}
			?>
</td>
<td><a class=underlined href='<?= $GLOBALS['PATH']."/catalog/item-".$TEMPLATE['sid'][$n]."&amp;b=".urlencode($TEMPLATE['btitle'][$n])."&amp;t=".urlencode($TEMPLATE['ftitle'][$n]) ?>'><?= $TEMPLATE['country'][$n] ?></a></td>
<!--<td><a class=underlined href='<?= $GLOBALS['PATH']."/catalog/item-".$TEMPLATE['sid'][$n]."&amp;b=".urlencode($TEMPLATE['btitle'][$n])."&amp;t=".urlencode($TEMPLATE['ftitle'][$n]) ?>'><?= $material ?></a></td>-->
<td><a class=underlined href='<?= $GLOBALS['PATH']."/catalog/item-".$TEMPLATE['sid'][$n]."&amp;b=".urlencode($TEMPLATE['btitle'][$n])."&amp;t=".urlencode($TEMPLATE['ftitle'][$n]) ?>'><?= $t[$TEMPLATE['av'][$n]] ?></a></td>
<td><a href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $TEMPLATE['sid'][$n] ?>&amp;b=<?= urlencode($TEMPLATE['btitle'][$n]) ?>&amp;t=<?= urlencode($TEMPLATE['ftitle'][$n]) ?>'><?= $TEMPLATE['price'][$n] ?> руб.</a>
<?php
if($TEMPLATE['action'][$n]!=""){	
	echo "<br><a href=\"".$PATH."/static/special\" style=\"color:red;font-weight:bold\">Акция!!!</a>";
}
?>	
</td>
<td><input style="width:25px;" id=i<?= $id ?> value="<?= $searchv ?>"></td>
<td>
<?php
if($TEMPLATE['price'][$n]!=0){
	echo " &nbsp; <a href='javascript:addToCart({$id}, {$TEMPLATE['price'][$n]},{$tid});'><img title='купить  {$TEMPLATE['description'][$n]}' alt='купить  {$TEMPLATE['description'][$n]}' src='" . $GLOBALS['PATH'] . "/templates/blank/img/cartadd.png'></a>";
} 
?>
</td></tr>

<?php
}
?>

<!--sub-->
</table></td></tr>
<!--end-->








<?php

} elseif($TEMPLATE['id']){
?>
<tr id=tr_<?= $TEMPLATE['id'] ?> <?php
	$searchv = 1;
	if(!$_COOKIE['cart_item_id']){
	$_COOKIE['cart_item_id']=array();
	}
	if(in_array($TEMPLATE['id'], $_COOKIE['cart_item_id'])) {
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
<td><?php if(!isset($TEMPLATE['mlinks'])) echo $TEMPLATE['ftitle']; else echo $TEMPLATE['model']; ?></td>
<?php } else { ?>
<td>
<?php
			$fl="";
			if(file_exists("/home/users/g/gruz-zap88/domains/custom-truck.ru/uploaded/small_{$TEMPLATE['sid']}.jpeg")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['sid']}.jpeg";
			if(file_exists("/home/users/g/gruz-zap88/domains/custom-truck.ru/uploaded/small_{$TEMPLATE['sid']}.png")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['sid']}.png";
			if(file_exists("/home/users/g/gruz-zap88/domains/custom-truck.ru/uploaded/small_{$TEMPLATE['sid']}.gif")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['sid']}.gif";
			if($fl){
				echo "<a href='{$GLOBALS['PATH']}/catalog/".$linkage.$TEMPLATE['sid']."&amp;b=".urlencode($TEMPLATE['btitle'])."&amp;t=".urlencode($TEMPLATE['ftitle'])."' title='увеличить'><img src='$fl' alt='".$TEMPLATE['description']."'></a>";
			} else {
				echo "<a href='{$GLOBALS['PATH']}/catalog/".$linkage.$TEMPLATE['sid']."&amp;b=".urlencode($TEMPLATE['btitle'])."&amp;t=".urlencode($TEMPLATE['ftitle'])."'><img src='{$GLOBALS['PATH']}/img/small_nofoto.jpg' alt=''></a>";			
			}
			?>
</td>
<td><a class=underlined href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $TEMPLATE['sid'] ?>&amp;b=<?= urlencode($TEMPLATE['btitle']) ?>&amp;t=<?= urlencode($TEMPLATE['ftitle']) ?>'><b><?= $TEMPLATE['oem'] ?></b></a></td>
<td><?php if (!isset($TEMPLATE['mlinks'])) echo $TEMPLATE['ftitle']; else echo $TEMPLATE['model']; ?></td>
<?php } ?>
<td><a class=underlined href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $TEMPLATE['sid'] ?>&amp;b=<?= urlencode($TEMPLATE['btitle']) ?>&amp;t=<?= urlencode($TEMPLATE['ftitle']) ?>'><?= $TEMPLATE['description'] ?></a>
<?php
if($TEMPLATE['action']!=""){	
	echo "<br><a href=\"".$PATH."/static/special\" style=\"color:red;font-weight:bold\">Акция!!!</a>";
}
?>	
</td>
<td class=rightal>
<?php 
if($TEMPLATE['price']!=0){
	echo $TEMPLATE['price']." руб."; 
} 
?>
</td>
<?php if($_GET['stat']!='archive'){ ?>
<td>
<input style="width:25px;" id=i<?= $TEMPLATE['id'] ?> value="<?= $searchv ?>" tabindex=<?= ($TEMPLATE['tabindex']*2-1) ?>>
</td>
<td>
<?php 
if($TEMPLATE['price']!=0){
	echo " &nbsp; <a href='javascript:addToCart({$TEMPLATE['id']}, {$TEMPLATE['price']});' tabindex=".($TEMPLATE['tabindex']*2)."><img title='купить  {$TEMPLATE['description']}' alt='купить  {$TEMPLATE['description']}' src='" . $GLOBALS['PATH'] . "/templates/blank/img/cartadd.png'></a>";
} 
?>			
</td>
<?php }
?>
</tr>

<?
}
?>




































