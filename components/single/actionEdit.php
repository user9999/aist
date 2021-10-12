<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
}
    //if (!isset($_GET['id'])) header("Location: " . $GLOBALS['PATH'] . "/404");
    set_title($GLOBALS['dblang_ctitle'][$GLOBALS['userlanguage']]);
    set_meta("", "");
    
    render_to_template("components/single/tpl/Header.php", array('title'=>$GLOBALS['dblang_ctitle'][$userlanguage],'menu'=>$GLOBALS['ssubmenu']));
//delete data
if (isset($_GET['del']) && isset($_GET['table'])) {
    mysql_query("DELETE FROM ".$PREFIX."".$_GET['table']." WHERE id='{$_GET['del']}'");
    mysql_query("DELETE FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['del']}' and table_name='".$_GET['table']."'");
    //header("Location: ?component=static"); 
}
//edit page
if (isset($_GET['edit']) && $_GET['table']=='single') {
    $res = mysql_query("select * from ".$PREFIX."single and a.id=".$_GET['edit']);
    if ($row = mysql_fetch_assoc($res)) {
        render_to_template($HOSTPATH."/components/single/tpl/Edit.php", $row);
    }
}

