<div class="content_body">
    <h3><?php echo $TEMPLATE['title'] ?><?php if($_GET['stat']=='archive') { ?> (Архив) <?php 
        } ?></h3>
    <div class=sortby>
<div class=sort1>Сортировать по:</div><a href="/<?php echo sorturl('title'); ?>" id=sorttitle>названию</a>  <div id=sortprice>по цене</div><a class=sprice href="/<?php echo sorturl('up'); ?>"><img src="/images/up.png" alt=""></a> <a class=sprice href="/<?php echo sorturl('down'); ?>" id=lprice><img src="/images/down.png" alt=""></a>
</div>



<?php
//mydump($TEMPLATE);


?>
