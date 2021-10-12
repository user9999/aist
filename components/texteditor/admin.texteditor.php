<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 

require_once 'inc/ckeditor/ckeditor.php' ;
require_once 'inc/ckfinder/ckfinder.php' ;
$ckeditor = new CKEditor();
$ckeditor->basePath    = 'inc/ckeditor/' ;
CKFinder::SetupCKEditor($ckeditor, 'inc/ckfinder/');

//delete static page
if (isset($_GET['del'])) {
    mysql_query("DELETE FROM ".$PREFIX."texts WHERE id='{$_GET['del']}'");
    mysql_query("DELETE FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['del']}' and table_name='texts'");
    header("Location: ?component=texteditor"); 
}

//edit static page
if (isset($_GET['edit'])) {
    $res = mysql_query("SELECT * FROM ".$PREFIX."texts WHERE id='{$_GET['edit']}'");
    if ($row = mysql_fetch_row($res)) {
        $tbl_path = $row[1];
        $res1 = mysql_query("SELECT * FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['edit']}' and table_name='texts'");
        while($row1=mysql_fetch_assoc($res1)){
            $tbl_meta[$row1['language']] = $row1['description'];
            $tbl_keys[$row1['language']] = $row1['keywords'];
            $tbl_text[$row1['language']] = $row1['content'];
        }
        $editid = $row[0];
    }
}

//add new static page
if (isset($_POST['frm_path']) && isset($_POST['frm_text'])) {

    $frm_path = mysql_real_escape_string($_POST['frm_path']);
    
    if (strlen($frm_path) >= 3) {
        //$frm_text=str_replace("<br />","<br>",$_POST['frm_text']);
        $frm_text=$_POST['frm_text'];
        //$frm_text = mysql_escape_string($frm_text);
        $frm_meta = $_POST['frm_meta'];
        $frm_keys = $_POST['frm_keys'];
        if (!$_POST['editid']) {
            mysql_query("INSERT INTO ".$PREFIX."texts SET `path` = '$frm_path',text='".$frm_text[$DLANG]."',keywords='".$frm_keys[$DLANG]."',meta='".$frm_meta[$DLANG]."'");
            $static_id=mysql_insert_id();
            foreach($frm_text as $lang=>$text){
                mysql_query("INSERT INTO ".$PREFIX."lang_text SET table_name='texts', rel_id=$static_id, language='$lang', `content`='".mysql_escape_string($text)."',`description`='".htmlspecialchars($frm_meta[$lang])."',`keywords`='".htmlspecialchars($frm_keys[$lang])."',pub_date='".time()."'");
            }
        } else {
            mysql_query("UPDATE ".$PREFIX."texts SET `path` = '$frm_path',text='".$frm_text[$DLANG]."',keywords='".$frm_keys[$DLANG]."',meta='".$frm_meta[$DLANG]."' WHERE id={$_POST['editid']}");
            foreach($frm_text as $lang=>$text){
                $res=mysql_query("select id from ".$PREFIX."lang_text where rel_id={$_POST['editid']} and table_name='texts' and language='{$lang}'");
                if(mysql_num_rows($res)>0) {
                    mysql_query("UPDATE ".$PREFIX."lang_text SET   `content`='".mysql_real_escape_string($text)."',`description`='".htmlspecialchars($frm_meta[$lang])."',`keywords`='".htmlspecialchars($frm_keys[$lang])."',pub_date='".time()."' where rel_id={$_POST['editid']} and table_name='texts' and language='$lang'");
                    //die("UPDATE ".$PREFIX."lang_text SET   `content`='".mysql_escape_string($text)."',`description`='".htmlspecialchars($frm_meta[$lang])."',`keywords`='".htmlspecialchars($frm_keys[$lang])."',pub_date='".time()."' where rel_id={$_POST['editid']} and table_name='texts' and language='$lang'");
                } else {
                    mysql_query("INSERT INTO ".$PREFIX."lang_text SET table_name='texts', rel_id={$_POST['editid']}, language='$lang', `content`='".mysql_real_escape_string($text)."',`description`='".htmlspecialchars($frm_meta[$lang])."',`keywords`='".htmlspecialchars($frm_keys[$lang])."',pub_date='".time()."'");
                }
            }
        }
        header("Location: ?component=texteditor");
    } else { echo "<b>Ошибка.</b> Минимальная длина пути - 3 символа";
    }
}
?>

<h1>Редактор текстов</h1>
Здесь вы можете редактировать тексты для страниц. Для этого используйте относительные пути и связывайте ваши тексты с путями.
<form method="post">
    <table width="100%">
        <tr>
            <td>Путь:</td><td><input class="textbox" name="frm_path" type="text" style="width: 100%;" value="<?php echo $tbl_path??'' ?>"></td>
        </tr>
<?php
foreach($LANGUAGES as $lang=>$path){
    ?>
        <tr>
            <td colspan=2 style="font-size:150%;background:#ccc">Язык : <?php echo $lang ?></td>
        </tr>    
        <tr>
            <td colspan="2"><textarea name="frm_text[<?php echo $lang ?>]" class="ckeditor" id="editor_ck[<?php echo $lang ?>]"><?php echo $tbl_text[$lang]??'' ?></textarea></td>
        </tr>
                        <tr>
            <td>Мета:</td><td><input class="textbox" name="frm_meta[<?php echo $lang ?>]" type="text" style="width: 100%;" value="<?php echo $tbl_meta[$lang]??'' ?>"></td>
        </tr>
                        <tr>
            <td>Ключевые слова:</td><td><input class="textbox" name="frm_keys[<?php echo $lang ?>]" type="text" style="width: 100%;" value="<?php echo $tbl_keys[$lang]??'' ?>"></td>
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
?>
<tr> 
<td colspan="2" align="right"><br /><input type='hidden' name='editid' value='<?php echo $editid??'' ?>'><input type="submit" class="button" value="Сохранить"></td>
</tr>    
</table>
</form>
<br />
<br />
<h1>Существующие тексты</h1>
<?php
$res = mysql_query("SELECT * FROM ".$PREFIX."texts");
$num = 0;
while ($row = mysql_fetch_row($res)) {
    $num++;
    echo $row[1] . " <a href='?component=texteditor&edit={$row[0]}'>[редактировать]</a> <a href='?component=texteditor&del={$row[0]}'>[удалить]</a><br />";
}
if ($num == 0) { echo "Тексты не добавлены";
}
?>
