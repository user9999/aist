<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
//htmldump($TEMPLATE,'template');

$linkage = "item-";
$dimension=explode(" ", $TEMPLATE['dimension']);
?>

<div class=product_item>
<div class=productphoto>
<?php
//var_dump($TEMPLATE,"template");
$fl = "";
if (file_exists("uploaded/small_{$TEMPLATE['id']}.jpeg")) { $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['id']}.jpeg";
}
if (file_exists("uploaded/small_{$TEMPLATE['id']}.png")) { $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['id']}.png";
}
if (file_exists("uploaded/small_{$TEMPLATE['id']}.gif")) { $fl = "{$GLOBALS['PATH']}/uploaded/small_{$TEMPLATE['id']}.gif";
}
            
if ($fl) {
    echo "<a href='{$GLOBALS['PATH']}/catalog/".$GLOBALS['catalog']."/".$linkage.$TEMPLATE['id']."'><img src='$fl' alt='{$TEMPLATE['itemtitle']}'></a>";//."&amp;b=".urlencode($TEMPLATE['btitle'])."&amp;t=".urlencode($TEMPLATE['ftitle'])."
} else {
    echo "<a href='{$GLOBALS['PATH']}/catalog/".$GLOBALS['catalog']."/".$linkage.$TEMPLATE['id']."'><img src='{$GLOBALS['PATH']}/images/no_image.png' alt=''></a>";//&amp;b=".urlencode($TEMPLATE['btitle'])."&amp;t=".urlencode($TEMPLATE['ftitle'])."    
}
?>
</div>
<div class=product_title><a class="item-title" href='<?php echo $GLOBALS['PATH'] ?>/catalog/<?php echo $GLOBALS['catalog'] ?>/<?php echo $linkage ?><?php echo $TEMPLATE['id'] ?>'><?php echo $TEMPLATE['itemtitle'] ?><?php echo $TEMPLATE['brand']." ".$TEMPLATE['model']." " ?></a><br>
</div>
<div class=item_desc>
<p class=articule>Артикул:<?php echo $TEMPLATE['oem'] ?></p>
<?php echo $TEMPLATE['description'] ?>
</div>
<div class=itemprice> 
<?php echo $TEMPLATE['price'] ?>  руб. 
</div>
<div class=itembuy><a class=buy href='javascript:addToCart(<?php echo $TEMPLATE['bid'] ?>, <?php echo $TEMPLATE['price'] ?>, 1);' title='купить  <?php echo $TEMPLATE['itemtitle'] ?>'>Купить</a>
</div>

</div>
