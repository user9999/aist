<div class=h2>Ваш заказ сформирован !</div>
<p>И скоро вы получите предложения без посредникав
В ближайшее время с вами свяжется наш специалист для уточнений тонкостей по вашему заказу</p>
<div class=h2>Для тех кто любит  держать все под контролем</div>

<form method=post>
<fieldset>
<div class=center>
<p><?=$TEMPLATE['name']?></p>
<div class=short_value><?=$TEMPLATE['value']?></div>
<input type=hidden name=id value="<?=$TEMPLATE['id']?>">
<p>подключено</p>
<input type=text name=price value="<?=$TEMPLATE['price']?>" readonly><br>
<a href="#" title="<?=$TEMPLATE['description']?>">Подробнее</a>
</div>
<fieldset>
<p>Проанализируем предложения
и дадим независимую оценку</p>
Сумма к оплате <?=$TEMPLATE['price']?> руб
<hr>
<input type=hidden name="id_order" value="<?=$TEMPLATE['id_order']?>">
<input type=hidden name="id_product" value="<?=$TEMPLATE['id_product']?>">

<input type=submit name=pay value="Оплатить"><br>
<a href="/order">Справлюсь самостоятельно</a>
</form>
