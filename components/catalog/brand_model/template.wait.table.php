<?php
$t = array("есть", "нет", "ожидается");
$script='<script type="text/javascript">
function reserve(det_id,tr_id){
amt=$("#a"+det_id).val();
$.post("/reserve.php", {id: tr_id,amount: $("#a"+det_id).val(),action:"preorder"},
function(data) {
$("#tr_"+tr_id).addClass("ordered");
$("#in_"+tr_id).text("заказано");
$("#res_"+tr_id).html("<a href=/preorder><img src=/img/ok.png alt=``></a>");
});
}
</script>';
set_script($script);
$res=mysql_query('select id from '.$PREFIX.'preorder where gruz_id="'.$TEMPLATE['gruz_id'].'" and user_id="'.$_SESSION['userid'].'"');
if(mysql_num_rows($res)>0){
$class='class="ordered"';
$input='заказано';
$reserve='<a href=/preorder><img src=/img/ok.png alt=""></a>';
} else {
$input='<input name=amount id=a'. $TEMPLATE['sid'].' size=1 value=1>';
$class='';
$reserve='<a onclick="reserve('.$TEMPLATE['sid'].','.$TEMPLATE['id'].');" style="cursor:pointer"><img alt="купить '.$TEMPLATE['description'].'" src="'.$GLOBALS['PATH'].'/templates/blank/img/rcartadd.png" /></a>';
}
?>

<tr id="tr_<?= $TEMPLATE['id'] ?>" <?= $class ?>>

<?php
if(isset($TEMPLATE['sid']) && $TEMPLATE['sid']){ 
	$linkage="item-"; 
} else {
	$linkage="price-";
	$TEMPLATE['sid']=$TEMPLATE['id'];
}
if(!$TEMPLATE['showimg']){ 
?>
<td><a href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $TEMPLATE['sid'] ?>'><b><?= $TEMPLATE['oem'] ?></b></a></td>
<td><?php if (!isset($TEMPLATE['mlinks'])) echo $TEMPLATE['ftitle']; else echo $TEMPLATE['model']; ?></td>
<?php } else { ?>
<td>
<?php
			$fl='';
			if(file_exists("uploaded/small_{$TEMPLATE['sid']}.jpeg")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['sid']}.jpeg";
			if(file_exists("uploaded/small_{$TEMPLATE['sid']}.png")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['sid']}.png";
			if(file_exists("uploaded/small_{$TEMPLATE['sid']}.gif")) $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['sid']}.gif";
				
			if ($fl) {
				echo "<a href=\"{$GLOBALS['PATH']}/catalog/".$linkage.$TEMPLATE['sid']."&amp;b=".urlencode($TEMPLATE['btitle'])."&amp;t=".urlencode($TEMPLATE['ftitle'])."\"><img src='$fl'></a>";
			}
?>
</td>
<td><a class=underlined href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $TEMPLATE['sid'] ?>&b=<?= $TEMPLATE['btitle'] ?>&t=<?= $TEMPLATE['ftitle'] ?>'><b><?= $TEMPLATE['oem'] ?></b></a></td>
<td><?php if (!isset($TEMPLATE['mlinks'])) echo $TEMPLATE['ftitle']; else echo $TEMPLATE['model']; ?></td>
<?php } ?>
<td><a class=underlined href='<?= $GLOBALS['PATH'] ?>/catalog/<?= $linkage ?><?= $TEMPLATE['sid'] ?>&b=<?= $TEMPLATE['btitle'] ?>&t=<?= $TEMPLATE['ftitle'] ?>'><?= $TEMPLATE['description'] ?> (<?= $TEMPLATE['country'] ?>)</a>
<?php
	if($TEMPLATE['action'] !=""){	
		echo '<br /><a href="'.$PATH.'/static/special" style="color:red;font-weight:bold">Акция!!!</a>';
	}
?>	
</td>
<td class=centeral>
<?php
  echo $TEMPLATE['av'];
?>
</td>
<td class=rightal>
<?php 
if($TEMPLATE['price']!=0){
	echo $TEMPLATE['price'].' '.$GLOBALS['ZNAK']; 
} 
?>
</td>
<td id=in_<?= $TEMPLATE['id'] ?>><?= $input ?></td>
<td id=res_<?= $TEMPLATE['id'] ?>><?= $reserve ?></td>
</tr>