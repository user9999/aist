<div id="div_<?= $TEMPLATE['id'] ?>" class="product">
	<div class="id" id="id_1"><?=$TEMPLATE['id']?></div>
<div class="name" id="name_1"><?=$TEMPLATE['name']?></div>
<div class="text" id="text_1"><?=$TEMPLATE['text']?></div>

<div class="public" id="public_1"><?=$TEMPLATE['public']?></div>
<div class="ymd" id="ymd_1"><?=$TEMPLATE['ymd']?></div>
<a href='/product/<?=$TEMPLATE['id']?>'><?=$TEMPLATE['name']?> - <?=$GLOBALS['dblang_show'][$GLOBALS['userlanguage']]?></a><br>
<a href='/product/view/<?=$TEMPLATE['id']?>'><?=$TEMPLATE['name']?> - <?=$GLOBALS['dblang_further'][$GLOBALS['userlanguage']]?></a>
	</div><br />