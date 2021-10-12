<?php
var_dump($TEMPLATE['values']);

foreach ($TEMPLATE['name'] as $option_id=>$name) {
    $select=helpFactory::activate('html/Select');
    $select->makeSelect($TEMPLATE['values'][$option_id], 0, 'option'.$option_id, 'options');
}
?>
<div  class="options">

</div>