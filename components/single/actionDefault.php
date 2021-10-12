<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
}
    //if (!isset($_GET['id'])) header("Location: " . $GLOBALS['PATH'] . "/404");
    set_title($GLOBALS['dblang_ctitle'][$GLOBALS['userlanguage']]);
    set_meta("", "");
    
    render_to_template("components/single/tpl/Header.php", array('title'=>$GLOBALS['dblang_ctitle'][$userlanguage],'menu'=>$GLOBALS['ssubmenu']));

$res = mysql_query("select * from ".$PREFIX."single");
$num = 0;
while ($row = mysql_fetch_assoc($res)) {

    //$tt=$row[1];

    render_to_template("components/single/tpl/List.php", $row);
    $num++;

}if ($num == 0) { echo $GLOBALS['dblang_norecords'][$GLOBALS['userlanguage']];
}
?>