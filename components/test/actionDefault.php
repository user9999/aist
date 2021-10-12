<?php if (!defined("SIMPLE_CMS")) die("Access denied");
//if (!isset($_GET['id'])) header("Location: " . $GLOBALS['PATH'] . "/404");
set_title($GLOBALS['dblang_ctitle'][$GLOBALS['userlanguage']]);
set_meta("", "");
$script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>";
set_script($script);
if($OUTPUT_FORMAT=='url' || $OUTPUT_FORMAT==''){
    render_to_template("components/test/tpl/Header.php",array('title'=>$GLOBALS['dblang_ctitle'][$userlanguage],'menu'=>$GLOBALS['ssubmenu']));
}
$res = mysql_query("select * from ".$PREFIX."test");
$num = 0;
while ($row = mysql_fetch_assoc($res)) {

    //$tt=$row[1];
$res1=mysql_query("SELECT title FROM ".$PREFIX."lang_text where table_name='test' and rel_id={$row['id']} and language='{$GLOBALS['userlanguage']}'");
    while($row1=mysql_fetch_array($res1)){
        $tt=$row1[0];
        $row['lang_title']=$row1[0];
        render_to_template("components/test/tpl/List.php",$row);
    }
    $num++;

}if ($num == 0) echo $GLOBALS['dblang_norecords'][$GLOBALS['userlanguage']];
?>