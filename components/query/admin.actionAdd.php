<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) die("Access denied"); 
	$script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>";
set_script($script);
	$error="";
//add record
if (isset($_POST['submit'])) {
	$phrase=(strlen($_POST['phrase'])>3)?mysql_real_escape_string($_POST['phrase']):$error.=$GLOBALS['dblang_ErPhrase1'][$DLANG];
$url=(strlen($_POST['url'])>3)?mysql_real_escape_string($_POST['url']):$error.=$GLOBALS['dblang_ErUrl1'][$DLANG];

	if($error==""){
		mysql_query("INSERT INTO `".$PREFIX."queries` SET phrase='{$phrase}',url='{$url}'");
		$rel_id=$id=mysql_insert_id();
		foreach($_POST['stufflang'] as $num=>$language){
			$title=mysql_real_escape_string($_POST['title'][$language]);
$short=mysql_real_escape_string($_POST['short'][$language]);
$content=mysql_real_escape_string($_POST['content'][$language]);
$description=mysql_real_escape_string($_POST['description'][$language]);
$keywords=mysql_real_escape_string($_POST['keywords'][$language]);
$pub_date=(strlen($_POST['pub_date'][$language])>6)?strtotime($_POST['pub_date'][$language]):time();
			mysql_query("INSERT INTO `".$PREFIX."lang_text` SET rel_id={$rel_id} ,table_name='queries',language='{$language}',title='{$title}',short='{$short}',content='{$content}',description='{$description}',keywords='{$keywords}',pub_date='{$pub_date}'");
		}
	}else{
		echo $error.$multierror;
	}
}
?>
<h1>Добавление записи</h1><form method="post"><label for="phrase"><?=$GLOBALS['dblang_phrase'][$DLANG]?> <input id="phrase" class="query" type=text name="phrase" value="<?=$tbl_phrase?>"></label><br><label for="url"><?=$GLOBALS['dblang_url'][$DLANG]?> <input id="url" class="query" type=text name="url" value="<?=$tbl_url?>"></label><br>
<?php
foreach($LANGUAGES as $lang=>$path){
?>
<div class=lang>Язык : <?= $lang ?></div>
<input type=hidden name="stufflang[]" value="<?= $lang ?>">
		<label for="title[<?= $lang ?>]"><?=$GLOBALS['dblang_title1'][$DLANG]?><input id="title[<?= $lang ?>]" type=text name="title[<?= $lang ?>]" value="<?=$tbl_title[$lang]?>"></label><label for="short[<?= $lang ?>]"><?=$GLOBALS['dblang_short1'][$DLANG]?><textarea id="short[<?= $lang ?>]" class="ckeditor" id="editor_ck12[<?= $lang ?>]" name="short[<?= $lang ?>]"><?=$tbl_short[$lang]?></textarea></label><label for="content[<?= $lang ?>]"><?=$GLOBALS['dblang_content1'][$DLANG]?><textarea id="content[<?= $lang ?>]" class="ckeditor" id="editor_ck13[<?= $lang ?>]" name="content[<?= $lang ?>]"><?=$tbl_content[$lang]?></textarea></label><label for="description[<?= $lang ?>]"><?=$GLOBALS['dblang_description1'][$DLANG]?><input id="description[<?= $lang ?>]" type=text name="description[<?= $lang ?>]" value="<?=$tbl_description[$lang]?>"></label><label for="keywords[<?= $lang ?>]"><?=$GLOBALS['dblang_keywords1'][$DLANG]?><input id="keywords[<?= $lang ?>]" type=text name="keywords[<?= $lang ?>]" value="<?=$tbl_keywords[$lang]?>"></label><label for="pub_date[<?= $lang ?>]"><?=$GLOBALS['dblang_pub_date1'][$DLANG]?><input id="pub_date[<?= $lang ?>]" type=text name="pub_date[<?= $lang ?>]" value="<?=date("d-m-Y",($tbl_pub_date[$lang])?$tbl_pub_date[$lang]:time())?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"></label>
<?php
}	
?><input type=submit name="submit" value="<?=$GLOBALS['dblang_button'][$DLANG]?>">
<input type='hidden' name='editid' value='<?= $editid ?>'>
</form>
