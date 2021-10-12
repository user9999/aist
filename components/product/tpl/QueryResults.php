<?php
//var_dump($TEMPLATE);
?>
<h2><?php echo $TEMPLATE['h1']?></h2>
<ul class="flex">
<?php
foreach ($TEMPLATE['categories'] as $url=>$name) {
    ?>
    <li><a href="<?php echo $url?>"><?php echo $name?></a>
<?php
}
?>
</ul>
<h2>Если не подошло сделайте заказ из формы ниже </h2>