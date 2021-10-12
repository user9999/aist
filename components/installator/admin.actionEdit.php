<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) die("Access denied"); 
/*include_once 'inc/ckeditor/ckeditor.php' ;
require_once 'inc/ckfinder/ckfinder.php' ;
$ckeditor = new CKEditor( ) ;
$ckeditor->basePath	= 'inc/ckeditor/' ;
CKFinder::SetupCKEditor($ckeditor, 'inc/ckfinder/');*///delete data
if (isset($_GET['del']) && isset($_GET['table'])) {
    mysql_query("DELETE FROM ".$PREFIX."".$_GET['table']." WHERE id='{$_GET['del']}'");
	mysql_query("DELETE FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['del']}' and table_name='".$_GET['table']."'");
    header("Location: ?component=static"); 
}
//edit page
if (isset($_GET['edit']) && $_GET['table']=='test') {
	$res = mysql_query("select * from ".$PREFIX."test and a.id=".$_GET['edit']);
	if (mysql_num_rows($res)) {
		while($row = mysql_fetch_assoc($res)){
			foreach($row as $name=>$value){
				$n="tbl_".$name;
				$$n[$row['language']] = $value;
			}
		}
		$editid = $row['id'];
	}
}
if (isset($_POST['submit'])) {
	$rel_id=$id=intval($_POST['editid']);
	$error="";
	//$test=(strlen($_POST['test'])>3)?mysql_real_escape_string($_POST['test'):$error.=$GLOBALS['dblang_ErTest1']['userlanguage'];
        //$testcontent=(strlen($_POST['testcontent'])>3)?mysql_real_escape_string($_POST['testcontent'):$error.=$GLOBALS['dblang_ErTestcontent1']['userlanguage'];

	if(($error.$multierror)==""){
		mysql_query("UPDATE `".$PREFIX."test` SET test='{$test}',testcontent='{$testcontent}' WHERE id=$id");
		foreach($_POST['stufflang'] as $num=>$language){
				$title=mysql_real_escape_string($_POST['title'][$language]);
$short=mysql_real_escape_string($_POST['short'][$language]);
$content=mysql_real_escape_string($_POST['content'][$language]);
$description=mysql_real_escape_string($_POST['description'][$language]);
$keywords=mysql_real_escape_string($_POST['keywords'][$language]);
$pub_date=mysql_real_escape_string($_POST['pub_date'][$language]);

				$res=mysql_query("select id from ".$PREFIX."lang_text where rel_id={$rel_id} and table_name='test' and language='{$lang}'");
				if(mysql_num_rows($res)>0){
                                        mysql_query("UPDATE `".$PREFIX."lang_text` SET title='{$title}',short='{$short}',content='{$content}',description='{$description}',keywords='{$keywords}',pub_date='{$pub_date}' WHERE rel_id=$rel_id and table_name='test' and language='{$language}'");
				} else {
					mysql_query("INSERT INTO `".$PREFIX."lang_text` SET table_name='test',rel_id={$rel_id},language='{$language}',title='{$title}',short='{$short}',content='{$content}',description='{$description}',keywords='{$keywords}',pub_date='{$pub_date}'");
				}
		}
	} else {
		echo $error.$multierror;
	}
}


?>
<h1>Редактирование</h1><form method="post"><label for="test"><?=$GLOBALS['dblang_test']['userlanguage']?> <input id="test" class="test" type=text name="test" value="<?= $tbl_test[$lang]?>"></label><br><label for="testcontent"><?=$GLOBALS['dblang_testcontent']['userlanguage']?> <textarea id="testcontent" class="test" class="ckeditor" id="editor_ck12m[<?= $lang ?>]" name="testcontent"><?= $tbl_testcontent[$lang]?></textarea></label><br>
<?php
foreach($LANGUAGES as $lang=>$path){
?>
<div class=lang>Язык : <?= $lang ?></div>
<input type=hidden name="stufflang" value="<?= $lang ?>">
		<label for="title"><?=$GLOBALS['dblang_title1']['userlanguage']?><input id="title" type=text name="title" value="<?= $tbl_title[$lang]?>"></label><label for="short"><?=$GLOBALS['dblang_short1']['userlanguage']?><textarea id="short" class="ckeditor" id="editor_ck12[<?= $lang ?>]" name="short[<?= $lang ?>]"><?= $tbl_short[$lang]?></textarea></label><label for="content"><?=$GLOBALS['dblang_content1']['userlanguage']?><textarea id="content" class="ckeditor" id="editor_ck13[<?= $lang ?>]" name="content[<?= $lang ?>]"><?= $tbl_content[$lang]?></textarea></label><label for="description"><?=$GLOBALS['dblang_description1']['userlanguage']?><input id="description" type=text name="description" value="<?= $tbl_description[$lang]?>"></label><label for="keywords"><?=$GLOBALS['dblang_keywords1']['userlanguage']?><input id="keywords" type=text name="keywords" value="<?= $tbl_keywords[$lang]?>"></label><label for="pub_date"><?=$GLOBALS['dblang_pub_date1']['userlanguage']?><input id="pub_date" type=text name="pub_date" value="<?= $tbl_pub_date[$lang]?>"></label>	<!--<script type="text/javascript">//<![CDATA[
	window.CKEDITOR_BASEPATH='inc/ckeditor/';
	//]]></script>
	<script type="text/javascript" src="inc/ckeditor/ckeditor.js?t=B1GG4Z6"></script>
	<script type="text/javascript">//<![CDATA[
	CKEDITOR.replace('editor_ck[<?= $lang ?>]', { "filebrowserBrowseUrl": "\/inc\/ckfinder\/ckfinder.html", "filebrowserImageBrowseUrl": "\/inc\/ckfinder\/ckfinder.html?type=Images", "filebrowserFlashBrowseUrl": "\/inc\/ckfinder\/ckfinder.html?type=Flash", "filebrowserUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Files", "filebrowserImageUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Images", "filebrowserFlashUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Flash" });
	//]]></script>-->
<?php
}	
?><input type=submit name="submit" value="<?=$GLOBALS['dblang_button']['userlanguage']?>">
<input type='hidden' name='editid' value='<?= $editid ?>'>
</form>
