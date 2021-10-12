<span class="variant_title">ВАРИАНТ- 2</span>
<p>Сформируйте сами

Несколько уточняющих вопросов  --Подтверждение  --Размещение заказа</p>

<?php
/*
foreach($TEMPLATE['name'] as $option_id=>$name){
?>
<label for=options><?=$name?></label>
<?
$select=helpFactory::activate('html/Select');
$select->makeSelect($TEMPLATE['values'][$option_id],0,'option'.$option_id,'options');

}
*/

echo configurator($TEMPLATE);
?>
<label for=address>Адрес</label><input type=text id=address name=address class="variant address" placeholder="">
<textarea name=comments class="variant comments"></textarea>
<input type=submit name=submit value="Оформить заказ">
</form>
