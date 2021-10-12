<?php if (!defined("SIMPLE_CMS")) die("Access denied");
//if (!isset($_GET['id'])) header("Location: " . $GLOBALS['PATH'] . "/404");
set_title($GLOBALS['dblang_ctitle'][$GLOBALS['userlanguage']]);
set_meta("", "");
$script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>";
set_script($script);
render_to_template("components/test/tpl/Header.php",array('title'=>$GLOBALS['dblang_ctitle'][$userlanguage],'menu'=>$GLOBALS['ssubmenu']));
$where=($segments[2])?' and a.id='.intval($segments[2]):'';$res2=mysql_query("SELECT a.*,b.language as language,b.title,b.short,b.content,b.description,b.keywords,b.pub_date from ".$PREFIX."test as a,".$PREFIX."lang_text as b WHERE a.id=b.rel_id and b.table_name='test' and b.language='{$GLOBALS['userlanguage']}'$where");
    while($row2=mysql_fetch_assoc($res2)){
        render_to_template("components/test/tpl/FullList.php",$row2);
    }
?>