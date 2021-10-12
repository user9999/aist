<div class="content_body">
    <h3><?php echo $TEMPLATE['title'] ?><?php if($_GET['stat']=='archive') { ?> (Архив) <?php 
        } ?></h3>
<?php
if($TEMPLATE['cat']) {
    echo $TEMPLATE['cat'];
    ?>
 &gt;&gt; <b>  <?php echo $TEMPLATE['title'] ?></b>
    <?php
} else {
    ?>
    <a class="underlined" href="<?php echo $GLOBALS['PATH'] ?>/catalog/<?php echo strtolower($TEMPLATE['bname']) ?>"> <?php echo ($TEMPLATE['baltname']) ? $TEMPLATE['baltname'] : $TEMPLATE['bname'] ?></a> &gt;&gt; <b>  <?php echo ($TEMPLATE['altname']) ? $TEMPLATE['altname'] : $TEMPLATE['name'] ?></b>
    <?php
}
if(file_exists("inc/update.php")) {
    include_once "inc/update.php";
    if($PRICEUPDATE) {
        echo "<p style=\"float:right\">Прайс-лист обновлен в ".$PRICEUPDATE."</p>";
    }
}
?>
<table style="width:100%" class="tb tablesorter" id="htable">
<thead>
<tr class="hd">
<?php if (!$TEMPLATE['showimg']) { ?>
<th style="width:19%">Фото</th>

<?php } else { ?>
<th style="width:15%">Фото</th>

<?php } ?>
<th style="width:20%" class="headerSortDown">Наименование</th>
<th style="width:12%" class="centeral">Производитель</th>
<th class="rightal">Цена</th>
<?php if ($_GET['stat']!='archive') { ?>
<th style="width:4%">Заказ <!--<?php echo $TEMPLATE['dimension'] ?>--></th>
<th style="width:4%">В корзину</th>
<?php } ?>
            <!--<th style="width:4%">Акция</th>-->
</tr>
</thead>
<tbody>
