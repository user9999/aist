<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) die("Access denied"); 
$css="<link rel=\"stylesheet\" href=\"".$PATH."/templates/admin.blank/image-upload.css\">\r\n";
set_css($css);
    $script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>\r\n"
            . "<script type='text/javascript' src='".$PATH."/templates/admin.blank/js/image-upload.js'></script>\r\n";
set_script($script);
	$error="";
//add record
if (isset($_POST['submit'])) {
    $title=mysql_real_escape_string($_POST['ntitle']);//(strlen($_POST['title'])>2)?mysql_real_escape_string($_POST['title']):$error.=$GLOBALS['dblang_ErTitle1'][$DLANG];
    //$short_text=mysql_real_escape_string($_POST['short_text']);//(strlen($_POST['short_text'])>3)?mysql_real_escape_string($_POST['short_text']):$error.=$GLOBALS['dblang_ErShort_text1'][$DLANG];
    //$full_text=mysql_real_escape_string($_POST['full_text']);//(strlen($_POST['full_text'])>3)?mysql_real_escape_string($_POST['full_text']):$error.=$GLOBALS['dblang_ErFull_text1'][$DLANG];
    //$keywords=mysql_real_escape_string($_POST['keywords']);//(strlen($_POST['keywords'])>3)?mysql_real_escape_string($_POST['keywords']):$error.=$GLOBALS['dblang_ErKeywords1'][$DLANG];
    //$description=mysql_real_escape_string($_POST['description']);//(strlen($_POST['description'])>3)?mysql_real_escape_string($_POST['description']):$error.=$GLOBALS['dblang_ErDescription1'][$DLANG];
    $images = ($_POST['images'])?json_encode($_POST['images'], JSON_UNESCAPED_UNICODE):'';
    $create_time=time();
    $pub_time='';
    $edit_time='';//(strlen($_POST['edit_time'])>3)?mysql_real_escape_string($_POST['edit_time']):$error.=$GLOBALS['dblang_ErEdit_time1'][$DLANG];
    $url=mysql_real_escape_string($_POST['url']);
    if($MY_URL==1){
        $error.=(chpu_check($url)=='exists')?'Такой url уже есть в базе':'';
    }
    if($error==""){
        $query="INSERT INTO `".$PREFIX."tidings` SET title='{$title}', images='{$images}',create_time='{$create_time}',pub_time='{$pub_time}',edit_time='{$edit_time}'";
        //echo $query;die();
        mysql_query($query);
        $rel_id=$id=mysql_insert_id();
        if($MY_URL==1){
            $query="INSERT INTO ".$PREFIX."url SET url='{$url}',component='tidings',cmsurl='tidings/{$rel_id}'";
            mysql_query($query);
        }
        foreach($_POST['stufflang'] as $num=>$language){
			$title=mysql_real_escape_string($_POST['title'][$language]);
$short=mysql_real_escape_string($_POST['short'][$language]);
$content=mysql_real_escape_string($_POST['content'][$language]);
$description=mysql_real_escape_string($_POST['description'][$language]);
$keywords=mysql_real_escape_string($_POST['keywords'][$language]);
$pub_date=(strlen($_POST['pub_date'][$language])>6)?strtotime($_POST['pub_date'][$language]):time();
            mysql_query("INSERT INTO `".$PREFIX."lang_text` SET rel_id={$rel_id} ,table_name='tidings',language='{$language}',title='{$title}',short='{$short}',content='{$content}',description='{$description}',keywords='{$keywords}',pub_date='{$pub_date}'");
        }
    } else {
        echo $error.$multierror;
    }
}
?>
<h1>Добавление записи</h1><form method="post">
    <div class="left">
    <label for="title"><?=$GLOBALS['dblang_title'][$DLANG]?> <input id="title" class="mainform tidings" type=text name="ntitle" value="<?=$tbl_title?>"></label><br>
     
   
    <!--<label for="short_text"><?=$GLOBALS['dblang_short_text'][$DLANG]?> <textarea id="short_text"  class="ckeditor" id="editor_ck12m[<?= $lang ?>]" name="short_text"><?=$tbl_short_text?></textarea></label><br>
   
    <label for="full_text"><?=$GLOBALS['dblang_full_text'][$DLANG]?> <textarea id="full_text" class="ckeditor" id="editor_ck13m[<?= $lang ?>]" name="full_text"><?=$tbl_full_text?></textarea></label><br>
    <label for="keywords"><?=$GLOBALS['dblang_keywords'][$DLANG]?> <input id="keywords" class="mainform tidings" type=text name="keywords" value="<?=$tbl_keywords?>"></label><br>
    <label for="description"><?=$GLOBALS['dblang_description'][$DLANG]?> <input id="description" class="mainform tidings" type=text name="description" value="<?=$tbl_description?>"></label><br>-->
    <label for="pub_time"><?=$GLOBALS['dblang_pub_time'][$DLANG]?> <input id="pub_time" class="mainform tidings" type=text name="pub_time" value="<?=$tbl_pub_time?>"></label><br>
            <?php
if($MY_URL==1){
?>
        <label for="url">URL(ЧПУ):
            <input id="url" class="mainform tidings translitto" name="url" type="text"  value="<?php echo $url??'' ?>">
        </label><br>  
<?php
}
?>
        </div>
 <div class="right">

           
<input id="sortpicture" type="file" name="sortpic" />
<button type="button" data-path="tidings" id="upload">Upload</button>
<div id="process"><img src="/components/product/tpl/img/preloader.gif" alt="Loading"></div>
<div id="photo-content">
<div id="div-default" class="img-item">
    <span id="del-default" class="delete-image">x</span>
    <img src="/img/default.jpg" width="120">
</div>   
</div>
            

    </div>
<?php
foreach($LANGUAGES as $lang=>$path){
?>
<div class=lang>Язык : <?= $lang ?></div>
<input type=hidden name="stufflang[]" value="<?= $lang ?>">
		<label for="title[<?= $lang ?>]"><?=$GLOBALS['dblang_title1'][$DLANG]?><input id="title[<?= $lang ?>]" type=text name="title[<?= $lang ?>]" value="<?=$tbl_title[$lang]?>"></label>
                <label for="short[<?= $lang ?>]"><?=$GLOBALS['dblang_short1'][$DLANG]?><textarea id="short[<?= $lang ?>]" class="ckeditor" id="editor_ck12[<?= $lang ?>]" name="short[<?= $lang ?>]"><?=$tbl_short[$lang]?></textarea></label>
                <label for="content[<?= $lang ?>]"><?=$GLOBALS['dblang_content1'][$DLANG]?><textarea id="content[<?= $lang ?>]" class="ckeditor" id="editor_ck13[<?= $lang ?>]" name="content[<?= $lang ?>]"><?=$tbl_content[$lang]?></textarea></label>
                <label for="description[<?= $lang ?>]"><?=$GLOBALS['dblang_description1'][$DLANG]?><input id="description[<?= $lang ?>]" type=text name="description[<?= $lang ?>]" value="<?=$tbl_description[$lang]?>"></label>
                <label for="keywords[<?= $lang ?>]"><?=$GLOBALS['dblang_keywords1'][$DLANG]?><input id="keywords[<?= $lang ?>]" type=text name="keywords[<?= $lang ?>]" value="<?=$tbl_keywords[$lang]?>"></label>
                <label for="pub_date[<?= $lang ?>]"><?=$GLOBALS['dblang_pub_date1'][$DLANG]?><input id="pub_date[<?= $lang ?>]" type=text name="pub_date[<?= $lang ?>]" value="<?=date("d-m-Y",($tbl_pub_date[$lang])?$tbl_pub_date[$lang]:time())?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"></label>
<?php
}	
?><input type=submit class=button name="submit" value="<?=$GLOBALS['dblang_button'][$DLANG]?>">
<input type='hidden' name='editid' value='<?= $editid ?>'>
</form>
