<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
}
    //if (!isset($_GET['id'])) header("Location: " . $GLOBALS['PATH'] . "/404");
    set_title($GLOBALS['dblang_ctitle'][$GLOBALS['userlanguage']]);
    set_meta("", "");
    
    render_to_template("components/single/tpl/Header.php", array('title'=>$GLOBALS['dblang_ctitle'][$userlanguage],'menu'=>$GLOBALS['ssubmenu']));
$where=($segments[2])?' where id='.intval($segments[2]):'';$res=mysql_query("select * from ".$PREFIX."single$where");
while($row=mysql_fetch_assoc($res)){
    render_to_template("components/single/tpl/FullList.php", $row);
}
?>