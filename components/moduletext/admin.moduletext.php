<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 

require_once 'inc/ckeditor/ckeditor.php' ;
require_once 'inc/ckfinder/ckfinder.php' ;
$ckeditor = new CKEditor();
$ckeditor->basePath    = 'inc/ckeditor/' ;
CKFinder::SetupCKEditor($ckeditor, 'inc/ckfinder/');


$table=helpFactory::activate('html/Table');
$check=array('position'=>'идентификатор','path'=>'страница');
$actions=array("/admin/?component=moduletext&edit="=>"id");
$table->setType('flex');
//delete static page
if (isset($_GET['del'])) {
    mysql_query("DELETE FROM ".$PREFIX."module_text WHERE id='{$_GET['del']}'");
    mysql_query("DELETE FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['del']}' and table_name='module_text'");
    header("Location: ?component=moduletext"); 
}

//edit static page
if (isset($_GET['edit'])) {
    $res = mysql_query("SELECT * FROM ".$PREFIX."module_text WHERE id='{$_GET['edit']}'");
    if ($row = mysql_fetch_row($res)) {
        $tbl_path = $row[1];
        $tbl_position = $row[3];
        $tbl_text = $row[2];
        
        /*
        $res1 = mysql_query("SELECT * FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['edit']}' and table_name='module_text'");
        while($row1=mysql_fetch_assoc($res1)){

            $tbl_text[$row1['language']] = $row1['content'];
        }
         */
        $editid = $row[0];
    }
}

//add new static page
if (isset($_POST['frm_path']) && isset($_POST['frm_text'])) {

    $frm_path = mysql_real_escape_string($_POST['frm_path']);
    $position = mysql_real_escape_string($_POST['frm_position']);
    $frm_path=($frm_path)?$frm_path:"index";
    if (strlen($frm_path) >= 1) {
        //$frm_text=str_replace("<br />","<br>",$_POST['frm_text']);
        $frm_text=$_POST['frm_text'];
        //$frm_text = mysql_escape_string($frm_text);

        if (!$_POST['editid']) {
            mysql_query("INSERT INTO ".$PREFIX."module_text SET `path` = '$frm_path',text='".$frm_text[$DLANG]."',position='{$position}'");
            $static_id=mysql_insert_id();
            foreach($frm_text as $lang=>$text){
                mysql_query("INSERT INTO ".$PREFIX."lang_text SET table_name='module_text', rel_id=$static_id, language='$lang', `content`='".mysql_escape_string($text)."', pub_date='".time()."'");
            }
        } else {
            mysql_query("UPDATE ".$PREFIX."module_text SET `path` = '$frm_path',text='".$frm_text[$DLANG]."',position='{$position}' WHERE id={$_POST['editid']}");
            foreach($frm_text as $lang=>$text){
                $res=mysql_query("select id from ".$PREFIX."lang_text where rel_id={$_POST['editid']} and table_name='module_text' and language='{$lang}'");
                if(mysql_num_rows($res)>0) {
                    mysql_query("UPDATE ".$PREFIX."lang_text SET `content`='".mysql_real_escape_string($text)."', pub_date='".time()."' where rel_id={$_POST['editid']} and table_name='module_text' and language='$lang'");
                    
                } else {
                    mysql_query("INSERT INTO ".$PREFIX."lang_text SET table_name='module_text', rel_id={$_POST['editid']}, language='$lang', `content`='".mysql_real_escape_string($text)."', pub_date='".time()."'");
                }
            }
        }
        header("Location: ?component=moduletext");
    } else { 
        echo "<b>Ошибка.</b> Минимальная длина пути - 3 символа";
    }
}

$options="";$mod_texts=array();
foreach (glob($HOSTPATH."/templates/".$TEMPLATE."/*template.php") as $file){
    $content=file_get_contents($file);
    preg_match_all("/\bget_moduletext\b[(]([^)]*)/", $content,$out);
    foreach($out[1] as $pos){
        
        $replace=array("'",'"');
        $pos=str_replace($replace,"",$pos);
        if($pos!=''){
            $mod_texts[]=$pos;
            //$selected=($pos==$tbl_position)?" selected":"";
            //$options.="<option value='{$pos}'{$selected}>{$pos}</option>";
        }
    }
}
$mod_texts= array_unique($mod_texts);
//dump_panel($mod_texts);
$select="<select name='frm_position'><option value=''>Выбрать</option>";
foreach($mod_texts as $val){
    //echo $val;
    $selected=($val==$tbl_position)?" selected":"";
    $options.="<option value='{$val}'{$selected}>{$val}</option>";
}

$options=($options=="")?"<option>Нет доступных позиций</option>":$options;
$select.=$options."</select>";
//var_dump($out[1]);


?>

<h1>Тексты модулей</h1>
Здесь вы можете редактировать тексты для страниц. Для этого используйте относительные пути и связывайте ваши тексты с путями.



<form method="post">
    <table width="100%">
        <tr>
            <td>Путь:</td><td><input class="textbox" name="frm_path" type="text" style="width: 100%;" value="<?php echo $tbl_path??'' ?>"></td>
        </tr>
        <tr>
            <td>alias(модуль):</td><td><?=$select?></td>
        </tr>
        <tr>
            <td colspan="2">
                <p>Текст</p>  
                <textarea name="frm_text" class="ckeditor" id="editor_ck"><?php echo $tbl_text ?></textarea>
            </td>
        </tr>
<?php
/*
foreach($LANGUAGES as $lang=>$path){
    ?>
        <tr>
            <td colspan=2 style="font-size:150%;background:#ccc">Язык : <?php echo $lang ?></td>
        </tr>    
        <tr>
            <td colspan="2"><textarea name="frm_text[<?php echo $lang ?>]" class="ckeditor" id="editor_ck[<?php echo $lang ?>]"><?php echo $tbl_text[$lang]??'' ?></textarea></td>
        </tr>

    <script type="text/javascript">//<![CDATA[
    window.CKEDITOR_BASEPATH='inc/ckeditor/';
    //]]></script>
    <script type="text/javascript" src="inc/ckeditor/ckeditor.js?t=B1GG4Z6"></script>
    <script type="text/javascript">//<![CDATA[
    CKEDITOR.replace('editor_ck[<?php echo $lang ?>]', { "filebrowserBrowseUrl": "\/inc\/ckfinder\/ckfinder.html", "filebrowserImageBrowseUrl": "\/inc\/ckfinder\/ckfinder.html?type=Images", "filebrowserFlashBrowseUrl": "\/inc\/ckfinder\/ckfinder.html?type=Flash", "filebrowserUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Files", "filebrowserImageUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Images", "filebrowserFlashUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Flash" });
    //]]></script>
</tr>
    <?php
} 
*/
?>
<tr> 
<td colspan="2" align="right"><br />
    <input type='hidden' name='editid' value='<?php echo $editid??'' ?>'>
    <input type="submit" class="button" value="Сохранить"></td>
</tr>    
</table>
</form>
<br />
<br />
<h1>Существующие тексты</h1>
<?php
$result=$table->makeTable('module_text', $check, "admin static", $actions, true);
?>
