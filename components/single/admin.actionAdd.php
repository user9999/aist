<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 
    
    $error="";
//add record
if (isset($_POST['submit'])) {
    $script=(strlen($_POST['script'])>3)?mysql_real_escape_string($_POST['script']):$error.=$GLOBALS['dblang_ErScript1'][$DLANG];
    $info=(strlen($_POST['info'])>3)?mysql_real_escape_string($_POST['info']):$error.=$GLOBALS['dblang_ErInfo1'][$DLANG];

    if($error=="") {
        mysql_query("INSERT INTO `".$PREFIX."single` SET script='{$script}',info='{$info}'");
        $rel_id=$id=mysql_insert_id();
        foreach($_POST['stufflang'] as $num=>$language){
            
            mysql_query("INSERT INTO `".$PREFIX."lang_text` SET rel_id={$rel_id} ,table_name='single',language='{$language}',");
        }
    } else {
        echo $error.$multierror;
    }
}
?>
<h1>Добавление записи</h1><form method="post"><label for="script"><?php echo $GLOBALS['dblang_script'][$DLANG]?> <textarea id="script" class="ckeditor" id="editor_ck11m[<?php echo $lang ?>]" name="script"><?php echo $tbl_script?></textarea></label><br><label for="info"><?php echo $GLOBALS['dblang_info'][$DLANG]?> <textarea id="info" class="ckeditor" id="editor_ck12m[<?php echo $lang ?>]" name="info"><?php echo $tbl_info?></textarea></label><br>
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
