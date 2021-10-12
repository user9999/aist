<br /><br /><div class="content_body">
<?php $title=($TEMPLATE['reserved'])?"Забронировано":"Ничего не забронировано"; ?>
    <h3><?php echo $title ?></h3>
<?php
if($TEMPLATE['reserved']) {
    ?>
    <table width="100%" class="tb tablesorter" id="htable" style="font-size:11px">
        <thead>
                <tr><th colspan="2"><a href="?component=reserve&action=1&clear=1" class="button" style="float:left;width:120px;height:22px">очистить</a></th><th></th><th></th><th></th><th></th><th></th><th></th><th><a href="javascript: void(0)" onclick="window.open('/reservecsv.php?action=<?php echo $TEMPLATE['action'] ?>','csv','width=20,height=20,top=0,left=0,resize=0');"><img src="/img/csv.png" alt="" title="Скачать одним файлом" /></a></th></tr>
        <tr class="hd">
            <th width="9%">Клиент</th>
            <th width="9%">ID</th>
            <th width="9%">OEM</th>
            <th width="14%">Марка/Модель</th>
            <th width="24%" class="headerSortDown">Наименование</th>
            <th class="rightal">Цена</th>
            <th width="3%">Шт.</th>

      <th width="4%">Акция</th>
      <th width="14%">Бронь до</th>
      <th width="3%"></th>
        </tr>
        </thead>
        <tbody>

    <?php
}
?>
