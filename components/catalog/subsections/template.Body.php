<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
//var_dump($TEMPLATE);
?>
<h2 class=title><?php echo $TEMPLATE['name'];?></h2>
<?php
echo $TEMPLATE['info'];
?>