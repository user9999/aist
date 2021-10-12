<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) die("Access denied");
$css="<link rel=\"stylesheet\" href=\"".$PATH."/templates/admin.blank/image-upload.css\">\r\n";
set_css($css);
$script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>\r\n"
            . "<script type='text/javascript' src='".$PATH."/templates/admin.blank/js/image-upload.js'></script>\r\n";
set_script($script);
//delete data
if (isset($_GET['del']) && isset($_GET['table'])) {
    mysql_query("DELETE FROM ".$PREFIX."".$_GET['table']." WHERE id='{$_GET['del']}'");
    mysql_query("DELETE FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['del']}' and table_name='".$_GET['table']."'");
    header("Location: ?component=tidings"); 
}
//edit page
if (isset($_GET['edit'])) {
    $res = mysql_query("select * from ".$PREFIX."tidings WHERE id=".$_GET['edit']);
	
    if ($row = mysql_fetch_assoc($res)) {
        foreach($row as $name=>$value){
            $n="tbl_".$name;
            ${$n} = $value;
        }
        $editid = $row['id'];
$res1 = mysql_query("SELECT  *,title as ltitle FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['edit']}' and table_name='tidings'");

        while($row1=mysql_fetch_assoc($res1)){
            foreach($row1 as $name=>$value){
                $n="tbl_".$name;
                ${$n}[$row1['language']] = $value;
            }
        }
        if($MY_URL==1){
            $query="SELECT * FROM ".$PREFIX."url WHERE cmsurl='tidings/{$_GET['edit']}' LIMIT 1";
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
	$tbl_title=mysql_real_escape_string($_POST['title']);//:$error.=$GLOBALS['dblang_ErTitle1'][$DLANG];
        //$short_text=(strlen($_POST['short_text'])>3)?mysql_real_escape_string($_POST['short_text']):$error.=$GLOBALS['dblang_ErShort_text1'][$DLANG];
        //$full_text=(strlen($_POST['full_text'])>3)?mysql_real_escape_string($_POST['full_text']):$error.=$GLOBALS['dblang_ErFull_text1'][$DLANG];
        //$keywords=(strlen($_POST['keywords'])>3)?mysql_real_escape_string($_POST['keywords']):$error.=$GLOBALS['dblang_ErKeywords1'][$DLANG];
        //$description=(strlen($_POST['description'])>3)?mysql_real_escape_string($_POST['description']):$error.=$GLOBALS['dblang_ErDescription1'][$DLANG];
        $images = ($_POST['images'])?json_encode($_POST['images'], JSON_UNESCAPED_UNICODE):'';
//$create_time=(strlen($_POST['create_time'])>3)?mysql_real_escape_string($_POST['create_time']):$error.=$GLOBALS['dblang_ErCreate_time1'][$DLANG];
        $pub_time=mysql_real_escape_string($_POST['pub_time']);//:$error.=$GLOBALS['dblang_ErPub_time1'][$DLANG];
        $edit_time=time();
/*
        if($MY_URL==1){
            if(chpu_check($frm_url,'tidings/'.$_POST['editid'])=='exists'){
                $error.='Введённый ЧПУ -"'.$alias.'" уже есть в базе<br />';
            }
        }
 */
 
	if($error==""){
            mysql_query("UPDATE `".$PREFIX."tidings` SET title='{$tbl_title}',images='{$images}', pub_time='{$pub_time}',edit_time='{$edit_time}' WHERE id=$id");
            if($MY_URL==1){
                if(chpu_check($frm_url,'tidings/'.$_POST['editid'])=='update'){
                    $query="UPDATE ".$PREFIX."url SET url='{$url}' WHERE cmsurl='tidings/{$_POST['editid']}'";
                }else{
                    $query="INSERT INTO ".$PREFIX."url SET url='{$url}',component='static',cmsurl='tidings/{$_POST['editid']}'";
                }
            }        
            foreach($_POST['stufflang'] as $num=>$language){
                $tbl_ltitle[$language]=mysql_real_escape_string($_POST['ltitle'][$language]);
                $short=mysql_real_escape_string($_POST['short'][$language]);
                $content=mysql_real_escape_string($_POST['content'][$language]);
                $description=mysql_real_escape_string($_POST['description'][$language]);
                $keywords=mysql_real_escape_string($_POST['keywords'][$language]);
                $pub_date=(strlen($_POST['pub_date'][$language])>6)?strtotime($_POST['pub_date'][$language]):time();
                $res=mysql_query("select id from ".$PREFIX."lang_text where rel_id={$rel_id} and table_name='tidings' and language='{$language}'");
                if(mysql_num_rows($res)>0){
                    mysql_query("UPDATE `".$PREFIX."lang_text` SET title='{$tbl_ltitle[$language]}',short='{$short}',content='{$content}',description='{$description}',keywords='{$keywords}',pub_date='{$pub_date}' WHERE rel_id=$rel_id and table_name='tidings' and language='$language'");
                } else {
                    mysql_query("INSERT INTO `".$PREFIX."lang_text` SET rel_id={$rel_id} ,table_name='tidings',language='{$language}',title='{$tbl_ltitle[$language]}',short='{$short}',content='{$content}',description='{$description}',keywords='{$keywords}',pub_date='{$pub_date}'");
                }
            }
	} else {
        echo $error.$multierror;
    }
}
if($tbl_images){
        $tbl_images= json_decode($tbl_images);
    }else{
        $tbl_images=['/img/default.jpg'];
}
?>
<h1>Редактирование</h1><form method="post">
    <div class="left">
    <label for="title"><?=$GLOBALS['dblang_title'][$DLANG]?> <input id="title" class="mainform tidings" type=text name="title" value="<?=$tbl_title?>"></label><br>
    <label for="pub_time"><?=$GLOBALS['dblang_pub_time'][$DLANG]?> <input id="pub_time" class="mainform tidings" type=text name="pub_time" value="<?=$tbl_pub_time?>"></label><br>
<?php
    if($MY_URL==1){
?>
        <label for="url">URL(ЧПУ):
            <input id="url" class="mainform tidings" name="url" type="text"  value="<?php echo $url??'' ?>">
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
<?php

foreach ($tbl_images as $image){
    if(strpos($image,'default')===false){
        $id= str_replace(array('/uploaded/product/',' ','/','.'),'', $image);
?>
    <div id="div-<?php echo $id?>" class="img-item">
    <span id="del-<?php echo $id;?>" class="delete-image">x</span>
    <img src="<?php echo $image?>" width="120"><input type="hidden" name="images[]" value="<?php echo $image;?>">
    </div> 
    
<?php
    }else{
?>
    <div id='div-default' class="img-item">
    <span id="del-default" class="delete-image">x</span>
    <img src="/img/default.jpg" width="120">
    </div>
<?php 
    }
}
?>  
</div>
            

    </div>
<?php
foreach($LANGUAGES as $lang=>$path){
?>
<div class=lang>Язык : <?= $lang ?></div>
<input type=hidden name="stufflang[]" value="<?= $lang ?>">
		<label for="title[<?= $lang ?>]"><?=$GLOBALS['dblang_title1'][$DLANG]?><input id="title[<?= $lang ?>]" type=text name="ltitle[<?= $lang ?>]" value="<?=$tbl_ltitle[$lang]?>"></label><label for="short[<?= $lang ?>]"><?=$GLOBALS['dblang_short1'][$DLANG]?><textarea id="short[<?= $lang ?>]" class="ckeditor" id="editor_ck12[<?= $lang ?>]" name="short[<?= $lang ?>]"><?=$tbl_short[$lang]?></textarea></label><label for="content[<?= $lang ?>]"><?=$GLOBALS['dblang_content1'][$DLANG]?><textarea id="content[<?= $lang ?>]" class="ckeditor" id="editor_ck13[<?= $lang ?>]" name="content[<?= $lang ?>]"><?=$tbl_content[$lang]?></textarea></label><label for="description[<?= $lang ?>]"><?=$GLOBALS['dblang_description1'][$DLANG]?><input id="description[<?= $lang ?>]" type=text name="description[<?= $lang ?>]" value="<?=$tbl_description[$lang]?>"></label><label for="keywords[<?= $lang ?>]"><?=$GLOBALS['dblang_keywords1'][$DLANG]?><input id="keywords[<?= $lang ?>]" type=text name="keywords[<?= $lang ?>]" value="<?=$tbl_keywords[$lang]?>"></label><label for="pub_date[<?= $lang ?>]"><?=$GLOBALS['dblang_pub_date1'][$DLANG]?><input id="pub_date[<?= $lang ?>]" type=text name="pub_date[<?= $lang ?>]" value="<?=date("d-m-Y",($tbl_pub_date[$lang])?$tbl_pub_date[$lang]:time())?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"></label>
<?php
}	
?><input type=submit class=button name="submit" value="<?=$GLOBALS['dblang_button'][$DLANG]?>">
<input type='hidden' name='editid' value='<?= $editid ?>'>
</form>
