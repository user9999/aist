<div class=content_body>
<h3><?php echo $TEMPLATE['title']?></h3>
<br>
<div style='float:right;font-weight:bold'>Вы заработали: <a href='<?php echo $PATH?>/account/witdraw'><?php echo $TEMPLATE['cash']?> руб.</a></div><br>
<p style='color:red'><?php echo $TEMPLATE['error']?></p>
<?php echo $TEMPLATE['content']?>
<div id="newsticker-gruzzap">    
<div style="visibility: visible; overflow: hidden; position: relative; z-index: 2; left: 0px; height: 435px;" class="gruzzap-jcarousellite">
<ul>
<?php
require "/home/g/gruzzapru/public_html/snipcode.php";
?>
</ul>
</div>
</div><br><br>
<?php echo $TEMPLATE['content1']?>

<?php
require "/home/g/gruzzapru/public_html/news.php";
?>
<br>
<h3>Скрипт партнерского магазина</h3>
<a href='javascript:void(0)' onclick="window.open('<? $_GLOBALS['PATH'] ?>/shop.php','shop','width=200,height=180,top=0,left=0,resize=0')">Скачать</a>
</div>
