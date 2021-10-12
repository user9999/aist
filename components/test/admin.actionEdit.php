<?php if (!defined("ADMIN_SIMPLE_CMS")) die("Access denied");
	$script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>";
set_script($script);
//delete data
if (isset($_GET['del']) && isset($_GET['table'])) {
    mysql_query("DELETE FROM ".$PREFIX."".$_GET['table']." WHERE id='{$_GET['del']}'");
    mysql_query("DELETE FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['del']}' and table_name='".$_GET['table']."'");
    header("Location: ?component=test"); 
}
//edit page
if (isset($_GET['edit']) && $_GET['table']=='test') {
    $res = mysql_query("select * from ".$PREFIX."test WHERE id=".$_GET['edit']);
	
    if ($row = mysql_fetch_assoc($res)) {
        foreach($row as $name=>$value){
            $n="tbl_".$name;
            ${$n} = $value;
        }
        $editid = $row['id'];
$res1 = mysql_query("SELECT * FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['edit']}' and table_name='test'");

        while($row1=mysql_fetch_assoc($res1)){
            foreach($row1 as $name=>$value){
                $n="tbl_".$name;
                ${$n}[$row1['language']] = $value;
            }
        }
        if($MY_URL==1){
            $query="SELECT * FROM ".$PREFIX."url WHERE cmsurl='test/{$_GET['edit']}' LIMIT 1";
            $result=mysql_query($query);
            $urlrow= mysql_fetch_array($result);
            $url=$urlrow['url'];
            
        }
	}
}
if (isset($_POST['submit'])) {
	$rel_id=$id=intval($_POST['editid']);
	$error="";
        if($MY_URL==1){
            $url=mysql_real_escape_string($_POST['url']);
        }
	$mail=(strlen($_POST['mail'])>3)?mysql_real_escape_string($_POST['mail']):$error.=$GLOBALS['dblang_ErMail1'][$DLANG];
$alias=(strlen($_POST['alias'])>3)?mysql_real_escape_string($_POST['alias']):$error.=$GLOBALS['dblang_ErAlias1'][$DLANG];
$name=(strlen($_POST['name'])>3)?mysql_real_escape_string($_POST['name']):$error.=$GLOBALS['dblang_ErName1'][$DLANG];

        if($MY_URL==1){
            $frm_url=mysql_real_escape_string($_POST['url']);
            if(chpu_check($frm_url,'test/'.$_POST['editid'])=='exists'){
                $error.='Введённый ЧПУ -"'.$alias.'" уже есть в базе<br />';
            }
        }
	if($error==""){
            mysql_query("UPDATE `".$PREFIX."test` SET mail='{$mail}',alias='{$alias}',name='{$name}' WHERE id=$id");
            if($MY_URL==1){
                if(chpu_check($frm_url,'test/'.$_POST['editid'])=='update'){
                    $query="UPDATE ".$PREFIX."url SET url='{$url}' WHERE cmsurl='test/{$_POST['editid']}'";
                }else{
                    $query="INSERT INTO ".$PREFIX."url SET url='{$url}',component='static',cmsurl='test/{$_POST['editid']}'";
                }
            }        foreach($_POST['stufflang'] as $num=>$language){
				$title=mysql_real_escape_string($_POST['title'][$language]);
$short=mysql_real_escape_string($_POST['short'][$language]);
$content=mysql_real_escape_string($_POST['content'][$language]);
$description=mysql_real_escape_string($_POST['description'][$language]);
$keywords=mysql_real_escape_string($_POST['keywords'][$language]);
$pub_date=(strlen($_POST['pub_date'][$language])>6)?strtotime($_POST['pub_date'][$language]):time();
                $res=mysql_query("select id from ".$PREFIX."lang_text where rel_id={$rel_id} and table_name='test' and language='{$language}'");
                if(mysql_num_rows($res)>0){
                    mysql_query("UPDATE `".$PREFIX."lang_text` SET title='{$title}',short='{$short}',content='{$content}',description='{$description}',keywords='{$keywords}',pub_date='{$pub_date}' WHERE rel_id=$rel_id and table_name='test' and language='$language'");
                } else {
                    mysql_query("INSERT INTO `".$PREFIX."lang_text` SET rel_id={$rel_id} ,table_name='test',language='{$language}',title='{$title}',short='{$short}',content='{$content}',description='{$description}',keywords='{$keywords}',pub_date='{$pub_date}'");
                }
            }
	} else {
        echo $error.$multierror;
    }
}
?>
<h1>Редактирование</h1><form method="post"><label for="mail"><?=$GLOBALS['dblang_mail'][$DLANG]?> <input id="mail" class="mainform test" type=text name="mail" value="<?=$tbl_mail?>"></label><br>
<label for="alias"><?=$GLOBALS['dblang_alias'][$DLANG]?> <input id="alias" class="mainform test" type=text name="alias" value="<?=$tbl_alias?>"></label><br>
<label for="name"><?=$GLOBALS['dblang_name'][$DLANG]?> <input id="name" class="mainform test" type=text name="name" value="<?=$tbl_name?>"></label><br>

<?php
if($MY_URL==1){
?>
        <label for="url">URL(ЧПУ):
            <input id="url" class="mainform test" name="url" type="text"  value="<?php echo $url??'' ?>">
        </label><br>  
<?php
}
?>

<?php
foreach($LANGUAGES as $lang=>$path){
?>
<div class=lang>Язык : <?= $lang ?></div>
<input type=hidden name="stufflang[]" value="<?= $lang ?>">
		<label for="title[<?= $lang ?>]"><?=$GLOBALS['dblang_title1'][$DLANG]?><input id="title[<?= $lang ?>]" type=text name="title[<?= $lang ?>]" value="<?=$tbl_title[$lang]?>"></label><label for="short[<?= $lang ?>]"><?=$GLOBALS['dblang_short1'][$DLANG]?><textarea id="short[<?= $lang ?>]" class="ckeditor" id="editor_ck12[<?= $lang ?>]" name="short[<?= $lang ?>]"><?=$tbl_short[$lang]?></textarea></label><label for="content[<?= $lang ?>]"><?=$GLOBALS['dblang_content1'][$DLANG]?><textarea id="content[<?= $lang ?>]" class="ckeditor" id="editor_ck13[<?= $lang ?>]" name="content[<?= $lang ?>]"><?=$tbl_content[$lang]?></textarea></label><label for="description[<?= $lang ?>]"><?=$GLOBALS['dblang_description1'][$DLANG]?><input id="description[<?= $lang ?>]" type=text name="description[<?= $lang ?>]" value="<?=$tbl_description[$lang]?>"></label><label for="keywords[<?= $lang ?>]"><?=$GLOBALS['dblang_keywords1'][$DLANG]?><input id="keywords[<?= $lang ?>]" type=text name="keywords[<?= $lang ?>]" value="<?=$tbl_keywords[$lang]?>"></label><label for="pub_date[<?= $lang ?>]"><?=$GLOBALS['dblang_pub_date1'][$DLANG]?><input id="pub_date[<?= $lang ?>]" type=text name="pub_date[<?= $lang ?>]" value="<?=date("d-m-Y",($tbl_pub_date[$lang])?$tbl_pub_date[$lang]:time())?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"></label>
<?php
}	
?><input type=submit class=button name="submit" value="<?=$GLOBALS['dblang_button'][$DLANG]?>">
<input type='hidden' name='editid' value='<?= $editid ?>'>
</form>
