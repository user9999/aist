<?php if ($TEMPLATE['error']): ?>
	<div class="error"><?=$TEMPLATE['error']?></div>
	<?php endif?><form method="post"><label for="pid"><?=$GLOBALS['dblang_pid'][$GLOBALS['userlanguage']]?> <input id="pid" class="product" type=text name="pid" value="<?=$TEMPLATE['pid']?>"></label><br><label for="name"><?=$GLOBALS['dblang_name'][$GLOBALS['userlanguage']]?> <input id="name" class="product" type=text name="name" value="<?=$TEMPLATE['name']?>"></label><br><label for="alias"><?=$GLOBALS['dblang_alias'][$GLOBALS['userlanguage']]?> <input id="alias" class="product" type=text name="alias" value="<?=$TEMPLATE['alias']?>"></label><br><label for="text"><?=$GLOBALS['dblang_text'][$GLOBALS['userlanguage']]?> <textarea id="text" class="ckeditor" id="editor_ck14m[<?= $lang ?>]" name="text"><?=$TEMPLATE['text']?></textarea></label><br><label for="price"><?=$GLOBALS['dblang_price'][$GLOBALS['userlanguage']]?> <input id="price" class="product" type=text name="price" value="<?=$TEMPLATE['price']?>"></label><br><label for="title[<?=$GLOBALS['userlanguage']?>]"><?=$GLOBALS['dblang_title1'][$GLOBALS['userlanguage']]?><input id="title[<?= $lang ?>]" type=text name="title[<?=$GLOBALS['userlanguage']?>]" value="<?=$TEMPLATE['title'][$lang]?>"></label><label for="short[<?=$GLOBALS['userlanguage']?>]"><?=$GLOBALS['dblang_short1'][$GLOBALS['userlanguage']]?><textarea id="short[<?=$GLOBALS['userlanguage']?>]" class="ckeditor" id="editor_ck12[<?=$GLOBALS['userlanguage']?>]" name="short[<?=$GLOBALS['userlanguage']?>]"><?=$TEMPLATE['short'][$GLOBALS['userlanguage']]?></textarea></label><label for="content[<?=$GLOBALS['userlanguage']?>]"><?=$GLOBALS['dblang_content1'][$GLOBALS['userlanguage']]?><textarea id="content[<?=$GLOBALS['userlanguage']?>]" class="ckeditor" id="editor_ck13[<?=$GLOBALS['userlanguage']?>]" name="content[<?=$GLOBALS['userlanguage']?>]"><?=$TEMPLATE['content'][$GLOBALS['userlanguage']]?></textarea></label><label for="description[<?=$GLOBALS['userlanguage']?>]"><?=$GLOBALS['dblang_description1'][$GLOBALS['userlanguage']]?><input id="description[<?= $lang ?>]" type=text name="description[<?=$GLOBALS['userlanguage']?>]" value="<?=$TEMPLATE['description'][$lang]?>"></label><label for="keywords[<?=$GLOBALS['userlanguage']?>]"><?=$GLOBALS['dblang_keywords1'][$GLOBALS['userlanguage']]?><input id="keywords[<?= $lang ?>]" type=text name="keywords[<?=$GLOBALS['userlanguage']?>]" value="<?=$TEMPLATE['keywords'][$lang]?>"></label><label for="pub_date[<?=$GLOBALS['userlanguage']?>]"><?=$GLOBALS['dblang_pub_date1'][$GLOBALS['userlanguage']]?><input id="pub_date[<?= $lang ?>]" type=text name="pub_date[<?=$GLOBALS['userlanguage']?>]" value="<?=date("d-m-Y", ($TEMPLATE['pub_date'][$lang]?$TEMPLATE[pub_date][$lang]:time()))?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"></label><label for='contact-secpic'><?=$GLOBALS['dblang_captcha'][$GLOBALS['userlanguage']] ?>: 
			<input type='text' id='contact-secpic' class='contact-secpic' name='secpic' tabindex='1010' /> <img src="/secpic.php" alt="защитный код"></label>
			<br/><input type=submit name="submit" value="<?=$GLOBALS['dblang_button'][$GLOBALS['userlanguage']]?>">