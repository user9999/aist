<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
}
    //if (!isset($_GET['id'])) header("Location: " . $GLOBALS['PATH'] . "/404");
    set_title($GLOBALS['dblang_ctitle'][$GLOBALS['userlanguage']]);
    set_meta("", "");
    $script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>";
set_script($script);
    render_to_template("components/registration/tpl/Header.php", array('title'=>$GLOBALS['dblang_ctitle'][$userlanguage],'menu'=>$GLOBALS['ssubmenu']));
$where=($segments[2])?' and a.id='.intval($segments[2]):'';$res2=mysql_query("SELECT a.*,b.language as language,b.nick,b.parent_id,b.email,b.phone,b.name,b.gender,b.birthdate,b.country,b.firm,b.password,b.actype,b.percent,b.udata,b.money,b.amount,b.level,b.ref_amount,b.points,b.regdate,b.ref2_amount,b.ref3_amount,b.ref4_amount,b.getref,b.systemref,b.tmp_pass,b.package,b.payed_till from ".$PREFIX." as a,".$PREFIX."users as b WHERE a.id=b.rel_id$where");
while($row2=mysql_fetch_assoc($res2)){

    render_to_template("components/registration/tpl/FullList.php", $row2);
}
?>