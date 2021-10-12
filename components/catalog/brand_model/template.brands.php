<div class=itemModels style="min-height: 240px;">
<a href="<?php echo $GLOBALS['PATH'] ?>/catalog/<?php echo $TEMPLATE['id'] ?>"><?php echo $TEMPLATE['name'] ?><br>
<?php if ($TEMPLATE['image']) { ?>
<img <?php echo get_alt($TEMPLATE['image']); ?> style="border:0" src="<?php echo $GLOBALS['PATH'] ?>/<?php echo $TEMPLATE['image'] ?>">
<?php } else { ?>
<img <?php echo get_alt("img/icons/default.jpg"); ?> style="border:0" src="<?php echo $GLOBALS['PATH'] ?>/img/icons/default.jpg">
<?php } ?>
</a>
</div>
