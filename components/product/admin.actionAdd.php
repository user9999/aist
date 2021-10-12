<?php 
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) {
    die("Access denied");
}
$css="<link rel=\"stylesheet\" href=\"".$PATH."/templates/admin.blank/image-upload.css\">\r\n";
set_css($css);
    $script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>\r\n"
            . "<script type='text/javascript' src='".$PATH."/templates/admin.blank/js/image-upload.js'></script>\r\n";
set_script($script);
    $error="";
//add record
if (isset($_POST['submit'])) {
    $pid=mysql_real_escape_string($_POST['pid']);
    $url=mysql_real_escape_string($_POST['url']);
    $images = ($_POST['images'])?json_encode($_POST['images'], JSON_UNESCAPED_UNICODE):'';
    $name=(strlen($_POST['name'])>3)?mysql_real_escape_string($_POST['name']):$error.=$GLOBALS['dblang_ErName1'][$DLANG];
    $alias=mysql_real_escape_string($_POST['alias']);
    $text=(strlen($_POST['text'])>3)?mysql_real_escape_string($_POST['text']):$error.=$GLOBALS['dblang_ErText1'][$DLANG];
    $price=mysql_real_escape_string($_POST['price']);
    if($MY_URL==1 && strlen($url)>0){
        $error.=(chpu_check($url)=='exists')?'Такой url уже есть в базе':'';
    }
    if ($error=="") {
        mysql_query("INSERT INTO `".$PREFIX."product` SET pid='{$pid}',name='{$name}',alias='{$alias}',text='{$text}',images='{$images}',price='{$price}'");
        $rel_id=$id=mysql_insert_id();
        if($MY_URL==1 && strlen($url)>0){
            $query="INSERT INTO ".$PREFIX."url SET url='{$url}',component='product',cmsurl='product/{$rel_id}'";
            mysql_query($query);
        }       
        
        foreach ($_POST['stufflang'] as $num=>$language) {
            $title=mysql_real_escape_string($_POST['title'][$language]);
            $short=mysql_real_escape_string($_POST['short'][$language]);
            $content=mysql_real_escape_string($_POST['content'][$language]);
            $description=mysql_real_escape_string($_POST['description'][$language]);
            $keywords=mysql_real_escape_string($_POST['keywords'][$language]);
            $pub_date=(strlen($_POST['pub_date'][$language])>6)?strtotime($_POST['pub_date'][$language]):time();
            mysql_query("INSERT INTO `".$PREFIX."lang_text` SET rel_id={$rel_id} ,table_name='product',language='{$language}',title='{$title}',short='{$short}',content='{$content}',description='{$description}',keywords='{$keywords}',pub_date='{$pub_date}'");
            //header("location: $MAINPATH/admin/?component=product&action=View&table=product&pid=$pid");
            echo "Запись добавлена!";
        }
    } else {
        echo $error.$multierror;
    }
}
?>
<h1>Добавление записи</h1>
<?php
    $qdop='';
    $pid=intval(strip_tags($_GET['pid']));
    if (!$pid) {
        $pid=0;
    }
    
    function genpath1($id, $tbl)
    {
        $r=mysql_query("select * from `kvn_product` where id=$id;");
        $tmp=mysql_result($r, 0, 'pid');
        $s='<a href="?component=product&action=View&table=product&pid='.$id.'">'.mysql_result($r, 0, 'name').'</a>';
        if ($tmp>0) {
            $s=genpath1($tmp, product).' &raquo; '.$s;
        }
        return $s;
    }

if ($pid) {
    echo '<a href=?component=product&action=View&table=product&pid=0>Изделия</a> &raquo; '.genpath1($pid, 'kvn_product').'<hr>';
}
?>



<form method="post">
    <div class="left">
    <label for="pid"><?=$GLOBALS['dblang_pid'][$DLANG]?> 
        
<?php
$recurse=helpFactory::activate('queries/QueryRecursive');
$array=$recurse->makeQuery('product','pid','id,name,alias','ORDER BY id');//
$select=helpFactory::activate('queries/Visitor/FormatRecursive','select');
$select->name="pid";
$select->class="product";
if(intval($_GET['add'])>0){
    $select->active_items=array($_GET['add']);
}
$select->symbol="|--";
$out=$select->format($recurse);
echo $out;
        ?>

        </label>
    
        <br><label for="name"><?=$GLOBALS['dblang_name'][$DLANG]?> 
            <input id="name" class="product" type=text name="name" value="<?=$tbl_name?>">
        </label><br>
        <label for="alias"><?=$GLOBALS['dblang_alias'][$DLANG]?> 
            <input id="alias" class="product translitto" type=text name="alias" value="<?=$tbl_alias?>">
        </label><br>
        
<?php
if($MY_URL==1){
?>
        <label for="url">URL(ЧПУ):
            <input id="url" class="product translitto" name="url" type="text"  value="<?php echo $url??'' ?>">
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
<div id="div-default" class="img-item">
    <span id="del-default" class="delete-image">x</span>
    <img src="/img/default.jpg" width="120">
</div>   
</div>
            
        </div>
        <br>
        <label for="text"><?=$GLOBALS['dblang_text'][$DLANG]?> 
            <textarea id="text" class="ckeditor" id="editor_ck14m[<?= $lang ?>]" name="text"><?=$tbl_text?></textarea>
        </label>
        <br>
<?php
foreach ($LANGUAGES as $lang=>$path) {
    ?>
<div class=lang>Язык : <?= $lang ?></div>
<input type=hidden name="stufflang[]" value="<?= $lang ?>">
		<label for="title[<?= $lang ?>]"><?=$GLOBALS['dblang_title1'][$DLANG]?><input id="title[<?= $lang ?>]" type=text name="title[<?= $lang ?>]" value="<?=$tbl_title[$lang]?>"></label><label for="short[<?= $lang ?>]"><?=$GLOBALS['dblang_short1'][$DLANG]?><textarea id="short[<?= $lang ?>]" class="ckeditor" id="editor_ck12[<?= $lang ?>]" name="short[<?= $lang ?>]"><?=$tbl_short[$lang]?></textarea></label><label for="content[<?= $lang ?>]"><?=$GLOBALS['dblang_content1'][$DLANG]?><textarea id="content[<?= $lang ?>]" class="ckeditor" id="editor_ck13[<?= $lang ?>]" name="content[<?= $lang ?>]"><?=$tbl_content[$lang]?></textarea></label><label for="description[<?= $lang ?>]"><?=$GLOBALS['dblang_description1'][$DLANG]?><input id="description[<?= $lang ?>]" type=text name="description[<?= $lang ?>]" value="<?=$tbl_description[$lang]?>"></label><label for="keywords[<?= $lang ?>]"><?=$GLOBALS['dblang_keywords1'][$DLANG]?><input id="keywords[<?= $lang ?>]" type=text name="keywords[<?= $lang ?>]" value="<?=$tbl_keywords[$lang]?>"></label><label for="pub_date[<?= $lang ?>]"><?=$GLOBALS['dblang_pub_date1'][$DLANG]?><input id="pub_date[<?= $lang ?>]" type=text name="pub_date[<?= $lang ?>]" value="<?=date("d-m-Y", ($tbl_pub_date[$lang])?$tbl_pub_date[$lang]:time())?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"></label>
<?php
}
?><input class="button" type=submit name="submit" value="<?=$GLOBALS['dblang_button'][$DLANG]?>">
<input type='hidden' name='editid' value='<?= $editid ?>'>
</form>
