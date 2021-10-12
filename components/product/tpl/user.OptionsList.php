<p>Несколько уточняющих вопросов  --Подтверждение  --Размещение заказа</p>

<?php
/*
foreach($TEMPLATE['name'] as $option_id=>$name){

<label for=options><?=$name?></label>

$select=helpFactory::activate('html/Select');
$select->makeSelect($TEMPLATE['values'][$option_id],0,'option'.$option_id,'options');
}
*/
?>
<?php

echo configurator($TEMPLATE);

?>
<label for=address>Адрес</label><input type=text id=address name=address class="variant address" placeholder="">
<textarea name=comments class="variant comments"></textarea>
<input type=submit name=submit value="Оформить заказ">
</form>

<?php
/*
$recursive_array=prepareRecursive('product','pid','id,name','ORDER BY id');
//$items=count($recursive_array[array_key_first($recursive_array)]); //- количество элементов первого уровня

    $treeHTML['begin']='<select class="">';
    $treeHTML['end']='</select>';
    $treeHTML['beginparent']="";
    $treeHTML['elementparent']="<option class='{class}' value='{id}'>{name}</option>\r\n";
    $treeHTML['endparent']="";

    $treeHTML['blockbeginchild']='';
    $treeHTML['beginchild']="";
    $treeHTML['elementchild']="<option class='{class}' value='{id}'>{name}</option>\r\n";
    $treeHTML['endchild']="";
    $treeHTML['blockendchild']="";

$replaces=array('id','name'); //что на что заменять (поля базы)

$menu=recursiveTree(0, 0,10,$recursive_array,$replaces,$treeHTML);
echo $recursive_menu;
*/
?>