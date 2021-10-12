<?php if (!defined("SIMPLE_CMS")) {
    die("Access denied");
}
    //if (!isset($_GET['id'])) header("Location: " . $GLOBALS['PATH'] . "/404");
    set_title($GLOBALS['dblang_ctitle'][$GLOBALS['userlanguage']]);
    set_meta("", "");
    $script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>";
    set_script($script);
    render_to_template("components/product/tpl/Header.php", array('title'=>$GLOBALS['dblang_ctitle'][$userlanguage],'menu'=>$GLOBALS['ssubmenu']));

//echo "segments=";var_dump($segments);
if ($segments[1]!='default') {
    $pid=intval($segments[1]);
} else {
    $pid=0;
}
    $res = mysql_query("select * from ".$PREFIX."product WHERE pid={$pid}");
    $num = 0;
    while ($row = mysql_fetch_array($res)) {
        $row['images']=(row['images'])?json_decode(row['images']):array(0=>'/img/icons/default.0.png');

    //$tt=$row[1];
        //$res1=mysql_query("SELECT title FROM ".$PREFIX."lang_text where table_name='product' and rel_id={$row['id']} and language='{$GLOBALS['userlanguage']}'");
        //while($row1=mysql_fetch_row($res1)){
        //$tt=$row1[0];
        //$row['lang_title']=$row1[0];
        render_to_template("components/product/tpl/List.php", $row);
        //}
        $num++;
    }

if ($num == 0) {
    echo $GLOBALS['dblang_norecords'][$GLOBALS['userlanguage']];
}
