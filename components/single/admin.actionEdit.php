<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
}
    
//delete data
if (isset($_GET['del']) && isset($_GET['table'])) {
    mysql_query("DELETE FROM ".$PREFIX."".$_GET['table']." WHERE id='{$_GET['del']}'");
    mysql_query("DELETE FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['del']}' and table_name='".$_GET['table']."'");
    header("Location: ?component=static"); 
}
//edit page
if (isset($_GET['edit']) && $_GET['table']=='single') {
    $res = mysql_query("select * from ".$PREFIX."single WHERE id=".$_GET['edit']);
    
    if ($row = mysql_fetch_assoc($res)) {
        foreach($row as $name=>$value){
            $n="tbl_".$name;
            ${$n} = $value;
        }
        $editid = $row['id'];    
    }
}
if (isset($_POST['submit'])) {
    $rel_id=$id=intval($_POST['editid']);
    $error="";
    $script=(strlen($_POST['script'])>3)?mysql_real_escape_string($_POST['script']):$error.=$GLOBALS['dblang_ErScript1'][$DLANG];
    $info=(strlen($_POST['info'])>3)?mysql_real_escape_string($_POST['info']):$error.=$GLOBALS['dblang_ErInfo1'][$DLANG];

    if($error=="") {
        mysql_query("UPDATE `".$PREFIX."single` SET script='{$script}',info='{$info}' WHERE id=$id");    
    } else {
         echo $error.$multierror;
    }
}
?>
<h1>Редактирование</h1><form method="post"><label for="script"><?php echo $GLOBALS['dblang_script'][$DLANG]?> <textarea id="script" class="ckeditor" id="editor_ck11m[<?php echo $lang ?>]" name="script"><?php echo $tbl_script?></textarea></label><br><label for="info"><?php echo $GLOBALS['dblang_info'][$DLANG]?> <textarea id="info" class="ckeditor" id="editor_ck12m[<?php echo $lang ?>]" name="info"><?php echo $tbl_info?></textarea></label><br>
<?php
foreach($LANGUAGES as $lang=>$path){
    ?>
<div class=lang>Язык : <?php echo $lang ?></div>
<input type=hidden name="stufflang[]" value="<?php echo $lang ?>">
        
    <?php
}    
?><input type=submit name="submit" value="Отправить">
<input type='hidden' name='editid' value='<?php echo $editid ?>'>
</form>
