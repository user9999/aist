<div class="content_body">
<?php $title=($TEMPLATE['reserved'])?"Вами забронированы следующие детали":"Вы еще ничего не забронировали"; ?>
    <h3 style="font-size:12px;font-weight:bold"><?php echo $title ?></h3>
<?php
if($TEMPLATE['reserved']) {
    ?>
    <table width="100%" class="tb tablesorter" id="htable" style="font-size:10px;">
        <thead>
        <tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th><a href="javascript: void(0)" onclick="window.open('/usercsv.php','csv','width=20,height=20,top=0,left=0,resize=0');"><img src="/img/csv.png" alt="" title="Скачать одним файлом" /></a></th></tr>
        <tr class="hd">
            <th width="15%">OEM</th>
            <th width="19%">Марка/Модель</th>
            <th width="26%" class="headerSortDown">Наименование</th>
            <th class="rightal">Цена</th>
            <th width="4%">Шт.</th>
      <th width="4%">Акция</th>
      <th width="17%">Бронь до</th>
      <th width="3%"></th>
        </tr>
        </thead>
        <tbody>
    <?php
}
?>