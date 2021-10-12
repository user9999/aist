<?php
if($TEMPLATE['reserved']) {
    if(!$TEMPLATE['top']) {
        $style="style=\"padding-top:0;margin-top:0\"";
    }
    ?>
<div class="content_body" <?php echo $style ?>><div style="margin:0;padding:0;height:25px">
    <?php
    if($TEMPLATE['top']) {
        ?>
<form method="post">
<div style="float:right;width:182px">
<a href="/preorder/id-all" class="addtcrt" style="display:block;width:180px;height:19px;font-size:10px;margin-top:0;padding-top:6px;margin-right:2px;margin-bottom:-10px">Очистить заказ</a><br>
<input type="submit" name="change" value="Сохранить изменения" style="width:180px;height:24px;font-size:10px;margin-top:0;padding-top:0px;margin-right:2px;background:#b10400;color:white;border:0px;padding-bottom:6px;cursor:pointer"/></div>
        <?php
    }
    ?>
    <p style="font-size:12px;font-weight:bold;padding-bottom:0px;padding-top:5px"><?php echo $TEMPLATE['title'] ?> <span id="Result"></span></p>
    <p style="font-size:12px;font-weight:bold;padding-bottom:0px;padding-top:0px"><a href="#sum<?php echo ($TEMPLATE['order'])?"on":"off"; ?>" style="text-decoration:underline;color:blue">Сумма заказанных деталей <?php echo ($TEMPLATE['order'])?"имеющихся на складе":"отсутствующих на складе"; ?></a></p>
    </div>
    <?php
    if($TEMPLATE['top']) {
        ?>
    
        <?php
    }
    ?>
    <table width="100%" class="tb tablesorter" id="htable" style="font-size:10px;">
        <thead>
                <tr><th><a href="javascript:void(0)" style="display:block;float:left" onclick="window.open('/usercsv.php?storage=<?php echo ($TEMPLATE['order'])?"on":"off"; ?>','csv','width=200,height=180,top=0,left=0,resize=0');"><img src="/img/csv.png" style="display:block;float:left" alt="" title="Скачать одним файлом" /> CSV</a>
                <a href="javascript:void(0)" style="display:block;float:left" onclick="window.open('/userxls.php?storage=<?php echo ($TEMPLATE['order'])?"on":"off"; ?>','csv','width=200,height=180,top=0,left=0,resize=0');"><img src="/img/csv.png" style="display:block;float:left" alt="" title="Скачать одним файлом" /> XLS</a></th><th></th><th></th><th></th><th colspan="3" style="padding:0;height:20px">
    <?php
    if($TEMPLATE['top']) {
        ?>
<a href="" class="addtcrt" id="sendToAdmin" style="width:180px;height:19px;float:right;font-size:10px;margin-top:2px">Оповестить администратора</a>
        <?php
    }
    ?>
</th></tr>
        <tr class="hd">
            <th width="15%">OEM</th>
            <th width="19%">Марка/Модель</th>
            <th width="26%" class="headerSortDown">Наименование</th>
            <th class="rightal">Цена</th>
            <th width="4%">Шт.</th>
      <th width="4%">Наличие</th>
      <th width="15%">Заказ /<br />Удаление </th>
        </tr>
        </thead>
        <tbody>
    <?php
} else {
    ?>
<!--<div class="content_body">
    <h3 style="font-size:12px;font-weight:bold;padding-bottom:0px;margin-bottom:0px">ПРЕДВАРИТЕЛЬНЫЙ ЗАКАЗ ОТСУТСТВУЕТ</h3>
</div>-->

    <?php
}
?>