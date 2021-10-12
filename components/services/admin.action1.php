<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 
//delete static page



$num = 0;

if (isset($_GET['del'])) {
    mysql_query("DELETE FROM ".$PREFIX."services WHERE id='{$_GET['del']}'");
    mysql_query("DELETE FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['del']}' and table_name='services'");
    
    header("Location: ?component=catalog"); 
}
$tbl_showmenu = 1;
//edit static page
if (isset($_GET['edit'])) {
    $res = mysql_query("SELECT * FROM ".$PREFIX."services WHERE id='{$_GET['edit']}'");
    if ($row = mysql_fetch_row($res)) {
        $tbl_alias = $row[2];
        $tbl_position = $row[3];
        $res1 = mysql_query("SELECT * FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['edit']}' and table_name='services'");
        while($row1=mysql_fetch_assoc($res1)){
            $tbl_name[$row1['language']] = $row1['title'];
            $tbl_info[$row1['language']] = $row1['content'];
            $tbl_keywords[$row1['language']] = $row1['keywords'];
            $tbl_description[$row1['language']] = $row1['description'];
            $tbl_short[$row1['language']] = $row1['short'];
        }
        $editid = $row[0];
    }
    
}
//add new static page
if (isset($_POST['frm_name'])) {
    $frm_name=$_POST["frm_name"];
    $frm_alias=$_POST['frm_alias'];
    $frm_keywords=$_POST['frm_keywords'];
    $frm_description=$_POST['frm_description'];
    $frm_info=$_POST['frm_info'];
    $frm_position=$_POST['frm_position'];
    $frm_short=$_POST["frm_short"];
    if (strlen($frm_name) >= 3) {
        if (!$_POST['editid']) {
            mysql_query("INSERT INTO ".$PREFIX."services SET alias='$frm_alias',position='$frm_position'");
            $static_id=mysql_insert_id();
            foreach($frm_name as $lang=>$name){
                mysql_query("INSERT INTO ".$PREFIX."lang_text SET table_name='services', rel_id=$static_id, language='$lang', title='$name' , short='{$frm_short[$lang]}', `content`='".mysql_escape_string($frm_info[$lang])."',`description`='".htmlspecialchars($frm_description[$lang])."',`keywords`='".htmlspecialchars($frm_keywords[$lang])."',pub_date='".time()."'");
            }
        } else {
            mysql_query("UPDATE ".$PREFIX."services SET alias='$frm_alias',position='$frm_position' WHERE id={$_POST['editid']}");
            foreach($frm_name as $lang=>$name){
                $res=mysql_query("select id from ".$PREFIX."lang_text where rel_id={$_POST['editid']} and table_name='services' and language='{$lang}'");
                if(mysql_num_rows($res)>0) {
                    mysql_query("UPDATE ".$PREFIX."lang_text SET   title='$name' , short='{$frm_short[$lang]}', `content`='".mysql_escape_string($frm_info[$lang])."',`description`='".htmlspecialchars($frm_description[$lang])."',`keywords`='".htmlspecialchars($frm_keywords[$lang])."',pub_date='".time()."' where rel_id={$_POST['editid']} and table_name='services' and language='$lang'");
                } else {
                    mysql_query("INSERT INTO ".$PREFIX."lang_text SET table_name='services', rel_id={$_POST['editid']}, language='$lang', title='$name' , short='{$frm_short[$lang]}', `content`='".mysql_escape_string($frm_info[$lang])."',`description`='".htmlspecialchars($frm_description[$lang])."',`keywords`='".htmlspecialchars($frm_keywords[$lang])."',pub_date='".time()."'");
                }
            }
        }
        header("Location: ?component=services");
    } else { echo "<b>Ошибка.</b> Минимальная длина названия - 3 символа";
    }
}
?>
<br><br>
<h1>Управление услугами</h1>
<form method="post" enctype="multipart/form-data">
<table width="100%">
<tr>
<td width="130">Порядок:</td>
<td><input type=text name=frm_position value="<?php echo $tbl_position ?>"></td>
</tr>
<tr>
<td><b>Алиас:</b></td><td><input class="textbox" name="frm_alias" type="text" style="width: 100%;" value="<?php echo $tbl_alias ?>" required></td>
</tr>
<?php
foreach($LANGUAGES as $lang=>$path){
    ?>
        <tr>
            <td colspan=2 style="font-size:150%;background:#ccc">Язык : <?php echo $lang ?></td>
        </tr>    

<tr>
<td width="130">Название:</td><td><input class="textbox" name="frm_name[<?php echo $lang ?>]" type="text" style="width: 100%;" value="<?php echo $tbl_name[$lang] ?>"></td>
</tr>

<tr>
<td><b>Ключевые:</b></td><td><input class="textbox" name="frm_keywords[<?php echo $lang ?>]" type="text" style="width: 100%;" value="<?php echo $tbl_keywords[$lang] ?>"></td>
</tr>
<tr>
<td><b>Описание (description):</b></td><td><input class="textbox" name="frm_description[<?php echo $lang ?>]" type="text" style="width: 100%;" value="<?php echo $tbl_description[$lang] ?>"></td>
</tr>
<tr>
<td><b>Описание коротко:</b></td><td><textarea name="frm_short[<?php echo $lang ?>]" type="text" style="width: 100%;"><?php echo $tbl_short[$lang] ?></textarea></td>
</tr>
<tr>
<tr>
            <td colspan="2"><textarea name="frm_info[<?php echo $lang ?>]" class="ckeditor" id="editor_ck[<?php echo $lang ?>]"><?php echo $tbl_info[$lang] ?></textarea>
                <script type="text/javascript">//<![CDATA[
    window.CKEDITOR_BASEPATH='inc/ckeditor/';
    //]]></script>
    <script type="text/javascript" src="inc/ckeditor/ckeditor.js?t=B1GG4Z6"></script>
    <script type="text/javascript">//<![CDATA[
    CKEDITOR.replace('editor_ck[<?php echo $lang ?>]', { "filebrowserBrowseUrl": "\/inc\/ckfinder\/ckfinder.html", "filebrowserImageBrowseUrl": "\/inc\/ckfinder\/ckfinder.html?type=Images", "filebrowserFlashBrowseUrl": "\/inc\/ckfinder\/ckfinder.html?type=Flash", "filebrowserUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Files", "filebrowserImageUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Images", "filebrowserFlashUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Flash" });
    //]]></script></td>
        </tr>

    <?php
}    
?>        

<tr> 
<td colspan="2" align="right"><input type='hidden' name='editid' value='<?php echo $editid ?>'><input type="submit" class="button" value="Сохранить">
</td>
</tr>
</table>

</form>
<br>
<br>

<h1>Существующие услуги</h1>
<?php
$res = mysql_query("SELECT * FROM ".$PREFIX."services");
$num = 0;
while ($row = mysql_fetch_row($res)) {
    $res1=mysql_query("SELECT title FROM ".$PREFIX."lang_text where table_name='services' and rel_id={$row[0]} and (language='en' or language='ru')");
    while($row1=mysql_fetch_row($res1)){
        $tt=$row1[0];
        break;
    }
    $num++;
    echo $tt . "  <a href='?component=services&edit={$row[0]}'>[редактировать]</a> <a href='?component=services&del={$row[0]}'>[удалить]</a><br />";
}
if ($num == 0) { echo "Услуги не добавлены";
}
?>
