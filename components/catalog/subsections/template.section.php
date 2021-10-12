<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
//var_dump($TEMPLATE);
?>
<div class=itemModels>
<div class=modelimage>
<?php
if($TEMPLATE['img'] && file_exists($GLOBALS['HOSTPATH']."/".$TEMPLATE['img'])) {

    ?>
<a href="<?php echo $TEMPLATE['link'];?>"><img src="<?php echo $TEMPLATE['img'];?>"></a>
    <?php
} else {
    ?>
<a href="<?php echo $TEMPLATE['link'];?>"><img src="/images/no_image.png"></a>

    <?php
}
?>
</div>
<h2 class=mod_title><a href="<?php echo $TEMPLATE['link'];?>"><?php echo $TEMPLATE['name'];?></a></h2>
</div>