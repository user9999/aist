<div class=content_body>
<h3 style="font-size:12px;font-weight:bold"><?php if (!isset($TEMPLATE['tt']) && !$TEMPLATE['showimg']) { ?>Кузовные запчасти к <?php 
                                            } ?><?php echo $TEMPLATE['title'] ?></h3>
<?php
echo '<p style=\"float:right\">Ваш прайс-лист обновлен в '.$TEMPLATE['update'].'</p>';
?>
<table class="tb tablesorter" id=htable style="font-size:10px;">
<thead>
<tr class=hd>
<?php if (!$TEMPLATE['showimg']) { ?>
<th width="19%">OEM</th>
<th width="22%">Модель</th>
<?php } else { ?>
<th width="15%">Изображение</th>
<th width="12%">OEM</th>
<th width="14%">Модель</th>
<?php } ?>
<th width="33%" class=headerSortDown>Наименование</th>
<th width="12%" class=centeral>Ожидается</th>
<th class=rightal>Цена</th>
<th>Кол-во</th>
<th>Предв.<br />заказ</th>
</tr></thead><tbody>