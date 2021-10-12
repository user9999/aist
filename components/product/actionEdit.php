<?php if (!defined("SIMPLE_CMS")) {
    die("Access denied");
}
    //if (!isset($_GET['id'])) header("Location: " . $GLOBALS['PATH'] . "/404");
    set_title($GLOBALS['dblang_ctitle'][$GLOBALS['userlanguage']]);
    set_meta("", "");
    $script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>";
set_script($script);
    render_to_template("components/product/tpl/Header.php", array('title'=>$GLOBALS['dblang_ctitle'][$userlanguage],'menu'=>$GLOBALS['ssubmenu']));
//delete data
if (isset($_GET['del']) && isset($_GET['table'])) {
    mysql_query("DELETE FROM ".$PREFIX."".$_GET['table']." WHERE id='{$_GET['del']}'");
    mysql_query("DELETE FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['del']}' and table_name='".$_GET['table']."'");
    //header("Location: ?component=static");
}
//edit page
if (isset($_GET['edit']) && $_GET['table']=='product') {
    $res = mysql_query("SELECT a.*,b.language as language,b.title,b.short,b.content,b.description,b.keywords,b.pub_date from ".$PREFIX."product as a,".$PREFIX."lang_text as b WHERE a.id=b.rel_id and b.table_name='product' and a.id=".$_GET['edit']);
    if ($row = mysql_fetch_assoc($res)) {
        render_to_template($HOSTPATH."/components/product/tpl/Edit.php", $row);
    }
}
