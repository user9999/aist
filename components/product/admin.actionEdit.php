<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) {
    die("Access denied");
}
$css="<link rel=\"stylesheet\" href=\"".$PATH."/templates/admin.blank/image-upload.css\">\r\n";
set_css($css);
    $script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>\r\n"
            . "<script type='text/javascript' src='".$PATH."/templates/admin.blank/js/image-upload.js'></script>\r\n";
    set_script($script);
//delete data
if (isset($_GET['del']) && isset($_GET['table'])) {
    $pid=intval(strip_tags($_GET['pid']));
    if (!$pid) {
        $pid = 0;
    }
    mysql_query("DELETE FROM ".$PREFIX."".$_GET['table']." WHERE id='{$_GET['del']}'");
    mysql_query("DELETE FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['del']}' and table_name='".$_GET['table']."'");
    header("Location: ?component=product&action=View&table=product&pid=$pid");
}
//edit page
if (isset($_GET['edit']) && $_GET['table']=='product') {
    $res = mysql_query("select * from ".$PREFIX."product WHERE id=".$_GET['edit']);
    
    if ($row = mysql_fetch_assoc($res)) {
        foreach ($row as $name=>$value) {
            $n="tbl_".$name;
            ${$n} = $value;
        }
        $editid = $row['id'];
        $parent_id=$row['pid'];
        $res1 = mysql_query("SELECT * FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['edit']}' and table_name='product'");

        while ($row1=mysql_fetch_assoc($res1)) {
            foreach ($row1 as $name=>$value) {
                $n="tbl_".$name;
                ${$n}[$row1['language']] = $value;
            }
        }
        if($MY_URL==1){
            $query="SELECT * FROM ".$PREFIX."url WHERE cmsurl='product/{$_GET['edit']}' LIMIT 1";
            $result=mysql_query($query);
            $urlrow= mysql_fetch_array($result);
            $url=$urlrow['url'];
            
        }
    }
}
if (isset($_POST['submit'])) {
    $rel_id=$id=intval($_POST['editid']);
    $error="";
    $pid=mysql_real_escape_string($_POST['pid']);
    $tbl_images = ($_POST['images'])?json_encode($_POST['images'], JSON_UNESCAPED_UNICODE):'';
    $name=(strlen($_POST['name'])>3)?mysql_real_escape_string($_POST['name']):$error.=$GLOBALS['dblang_ErName1'][$DLANG];
    $alias=(strlen($_POST['alias'])>0)?mysql_real_escape_string($_POST['alias']):$error.=$GLOBALS['dblang_ErAlias1'][$DLANG];
    $alias_count = '';
    if($MY_URL==1){
        $url=mysql_real_escape_string($_POST['url']);
    }
    if ($alias) {
        $result=mysql_query("SELECT count(*) FROM ".$PREFIX."product WHERE id<>'$id' && alias='$alias'");
        $row=mysql_fetch_array($result);
        $alias_count = $row[0];
    }
    //var_dump($alias_count);
    if ($alias_count) {
        $error.='Введённый Алиас -"'.$alias.'" уже есть в базе<br />';
    }

    $text=mysql_real_escape_string($_POST['text']);
    $price=mysql_real_escape_string($_POST['price']);
    if($MY_URL==1){
        if(chpu_check($frm_url,'product/'.$_POST['editid'])=='exists'){
            $error.='Введённый ЧПУ -"'.$alias.'" уже есть в базе<br />';
        }
    }
    if ($error=="") {
        mysql_query("UPDATE `".$PREFIX."product` SET pid='{$pid}',name='{$name}',alias='{$alias}',text='{$text}',images='{$tbl_images}',price='{$price}' WHERE id=$id");
        if($MY_URL==1){
            if(chpu_check($frm_url,'product/'.$_POST['editid'])=='update'){
                $query="UPDATE ".$PREFIX."url SET url='{$url}' WHERE cmsurl='product/{$_POST['editid']}'";
            }else{
                $query="INSERT INTO ".$PREFIX."url SET url='{$url}',component='static',cmsurl='product/{$_POST['editid']}'";
            }
        }
        //echo $query; die();
        mysql_query($query);
        foreach ($_POST['stufflang'] as $num=>$language) {
            $title=mysql_real_escape_string($_POST['title'][$language]);
            $short=mysql_real_escape_string($_POST['short'][$language]);
            $content=mysql_real_escape_string($_POST['content'][$language]);
            $description=mysql_real_escape_string($_POST['description'][$language]);
            $keywords=mysql_real_escape_string($_POST['keywords'][$language]);
            $pub_date=(strlen($_POST['pub_date'][$language])>6)?strtotime($_POST['pub_date'][$language]):time();
            $res=mysql_query("select id from ".$PREFIX."lang_text where rel_id={$rel_id} and table_name='product' and language='{$language}'");
            if (mysql_num_rows($res)>0) {
                mysql_query("UPDATE `".$PREFIX."lang_text` SET title='{$title}',short='{$short}',content='{$content}',description='{$description}',keywords='{$keywords}',pub_date='{$pub_date}' WHERE rel_id=$rel_id and table_name='product' and language='$language'");
            } else {
                mysql_query("INSERT INTO `".$PREFIX."lang_text` SET rel_id={$rel_id} ,table_name='product',language='{$language}',title='{$title}',short='{$short}',content='{$content}',description='{$description}',keywords='{$keywords}',pub_date='{$pub_date}'");
            }
            header("Location: ?component=product&action=View&table=product");
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
    <label for="pid"><?=$GLOBALS['dblang_pid'][$DLANG]?>
        <!--<input id="pid" class="product" type=text name="pid" value="<?=$tbl_pid?>" readonly>-->
        <?php
$recurse=helpFactory::activate('queries/QueryRecursive');
$array=$recurse->makeQuery('product','pid','id,name,alias','ORDER BY id');//
$select=helpFactory::activate('queries/Visitor/FormatRecursive','select');
$select->active_items=array($parent_id);
$select->name="pid";
$select->class="product";
$select->symbol="|--";
$out=$select->format($recurse);
echo $out;
        ?> 
    </label><br><label for="name"><?=$GLOBALS['dblang_name'][$DLANG]?> 
        <input id="name" class="product" type=text name="name" value="<?=$tbl_name?>">
    </label><br>
    <label for="alias"><?=$GLOBALS['dblang_alias'][$DLANG]?> 
        <input id="alias" class="product" type=text name="alias" value="<?=$tbl_alias?>">
    </label><br>
    <?php
if($MY_URL==1){
?>
        <label for="url">URL(ЧПУ):
            <input id="url" class="product" name="url" type="text"  value="<?php echo $url??'' ?>">
        </label><br>  
<?php
}
?>
    <label for="price"><?=$GLOBALS['dblang_price'][$DLANG]?> 
        <input id="price" class="product" type=text name="price" value="<?=$tbl_price?>">
    </label>
        </div>
        <div class="right">
           
<input id="sortpicture" type="file" name="sortpic" />
<button type="button" data-path="product" id="upload">Upload</button>
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
        
        <br>
    <label for="text"><?=$GLOBALS['dblang_text'][$DLANG]?> 
        <textarea id="text" class="ckeditor" id="editor_ck14m[<?= $lang ?>]" name="text"><?=$tbl_text?></textarea>
    </label><br>
<?php
foreach ($LANGUAGES as $lang=>$path) {
    ?>
<div class=lang>Язык : <?= $lang ?></div>
<input type=hidden name="stufflang[]" value="<?= $lang ?>">
		<label for="title[<?= $lang ?>]"><?=$GLOBALS['dblang_title1'][$DLANG]?><input id="title[<?= $lang ?>]" type=text name="title[<?= $lang ?>]" value="<?=$tbl_title[$lang]?>"></label><label for="short[<?= $lang ?>]"><?=$GLOBALS['dblang_short1'][$DLANG]?><textarea id="short[<?= $lang ?>]" class="ckeditor" id="editor_ck12[<?= $lang ?>]" name="short[<?= $lang ?>]"><?=$tbl_short[$lang]?></textarea></label><label for="content[<?= $lang ?>]"><?=$GLOBALS['dblang_content1'][$DLANG]?><textarea id="content[<?= $lang ?>]" class="ckeditor" id="editor_ck13[<?= $lang ?>]" name="content[<?= $lang ?>]"><?=$tbl_content[$lang]?></textarea></label><label for="description[<?= $lang ?>]"><?=$GLOBALS['dblang_description1'][$DLANG]?><input id="description[<?= $lang ?>]" type=text name="description[<?= $lang ?>]" value="<?=$tbl_description[$lang]?>"></label><label for="keywords[<?= $lang ?>]"><?=$GLOBALS['dblang_keywords1'][$DLANG]?><input id="keywords[<?= $lang ?>]" type=text name="keywords[<?= $lang ?>]" value="<?=$tbl_keywords[$lang]?>"></label><label for="pub_date[<?= $lang ?>]"><?=$GLOBALS['dblang_pub_date1'][$DLANG]?><input id="pub_date[<?= $lang ?>]" type=text name="pub_date[<?= $lang ?>]" value="<?=date("d-m-Y", ($tbl_pub_date[$lang])?$tbl_pub_date[$lang]:time())?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"></label>
<?php
}
?><input type=submit class="button" name="submit" value="<?=$GLOBALS['dblang_button'][$DLANG]?>">
<input type='hidden' name='editid' value='<?= $editid ?>'>
</form>
