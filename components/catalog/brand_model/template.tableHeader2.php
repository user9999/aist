<div class="content_body">
	<h3><?php if (!isset($TEMPLATE['tt']) && !$TEMPLATE['showimg']) { ?>Кузовные запчасти к <?php } ?><?= $TEMPLATE['title'] ?><?php if($_GET['stat']=='archive'){ ?> (Архив) <?php } ?></h3>
<?php
if(strpos($_GET['id'], "plastic-")!==false){
?>
<h3>Пластик <?= $TEMPLATE['bname'] ?></h3>
	<a class="underlined" href="<?= $GLOBALS['PATH'] ?>/catalog/plastic">Автопластик </a> &gt;&gt; <b>Пластик <?= $TEMPLATE['bname'] ?></b>

<?php
}
//var_dump($TEMPLATE);
if(file_exists("inc/update.php")){
  include_once "inc/update.php";
  if($PRICEUPDATE){
    echo "<p style=\"float:right\">Прайс-лист обновлен в ".$PRICEUPDATE."</p>";
  }
}
?>
<table class="tb tablesorter" id="htable">
<thead>
<tr class="hd">
<?php if (!$TEMPLATE['showimg']) { ?>
<th style="width:19%">OEM</th>
<th style="width:22%">Модель</th>
<?php } else { ?>
<th style="width:15%">Изображение</th>
<th style="width:12%">OEM</th>
<th style="width:14%">Модель</th>
<?php } ?>
<th style="width:33%" class="headerSortDown">Наименование</th>
<!--<th style="width:12%" class="centeral">Наличие</th>-->
<th class="rightal">Цена</th>
<?php if ($_GET['stat']!='archive') { ?>
<th style="width:4%">Заказ шт.</th>
<th>В корзину</th>
<?php } ?>
			<!--<th style="width:4%">Акция</th>-->
</tr>
</thead>
<tbody>
