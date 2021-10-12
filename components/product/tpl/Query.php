<?php
//var_dump($TEMPLATE);
?>
<form method=post>
    <input type="hidden" name="phrase" value="<?=$TEMPLATE['phrase']?>">
<input type=text name=phone class="variant phone" placeholder="+7(---)-------">
<input type=text name=fio class="variant fio" placeholder="Имя">
<label for=city>Город</label><input type=text id=address name=city class="variant yourcity" placeholder="Город" value="<?=$TEMPLATE['city']?>">
<label for=address>Адрес</label><input type=text id=address name=address class="variant address" placeholder="Адрес">
<textarea name=comments class="variant comments" placeholder="Опишите заказ"></textarea>
<label for=agree>Я принимаю условия <a href="/static/terms">передачи информации</a></label><checkbox name=agree id=agree class="variant agree" value=1>

<input type=submit name=submit value="Оформить заказ">
</form>