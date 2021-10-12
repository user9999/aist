<form method=post>
<div id="div_<?= $TEMPLATE['id'] ?>" class="product">
	<div class="id" id="id_1"><?=$TEMPLATE['id']?></div>
<div class="name" id="name_1"><?=$TEMPLATE['name']?></div>
<div class="text" id="text_1"><?=$TEMPLATE['text']?></div>
<div class="vdel" id="vdel_1"><?=$TEMPLATE['vdel']?></div>

<div class="title" id="title_1"><?=$TEMPLATE['title']?></div>
<div class="short" id="short_1"><?=$TEMPLATE['short']?></div>
<div class="content" id="content_1"><?=$TEMPLATE['content']?></div>
<div class="description" id="description_1"><?=$TEMPLATE['description']?></div>
</div><br />
<div class='product_content'>
<ul class=flex>
  <li class="flex"><img src='img/kithcen.png'></li>
  <li class="flex title">
	<div><span class="variant_title">ВАРИАНТ- 1</span>
	<p>Оставьте контакты — персональный менеджер поможет

осоветом и сформирует заказ, указав именно то что вам нужно</p>
<span class=result><?=$TEMPLATE['result']?></span>

<input type="hidden" name="id_product" value="<?=$TEMPLATE['id']?>">
<input type=text name=phone class="variant phone" placeholder="">
<input type=text name=fio class="variant fio" placeholder="ФИО">
<label for=agree>Я принимаю условия <a href="/static/terms">передачи информации</a></label><checkbox name=agree id=agree class="variant agree" value=1>
<input type=submit name=submit value="Оформить заказ">

	</div>  </li>
  </ul>
</div>