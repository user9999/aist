<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
$error="";
$template=($GLOBALS['TEMPLATE']=='blank')?'':$GLOBALS['TEMPLATE'].".";
set_title($GLOBALS['dblang_reviews'][$GLOBALS['userlanguage']]);
set_meta("", "");
if($_POST['comment']) {
    $uname=mysql_real_escape_string($_POST['uname']);
    $umail=mysql_real_escape_string($_POST['umail']);
    $title=mysql_real_escape_string($_POST['title']);
    $review=mysql_real_escape_string($_POST['review']);
    $error=(strlen($uname)<2)?$GLOBALS['dblang_shortName'][$GLOBALS['userlanguage']]:"";
    $error.=(strlen($umail)<9)?$GLOBALS['dblang_shortMail'][$GLOBALS['userlanguage']]:"";
    $error.=(strlen($title)<6)?$GLOBALS['dblang_shortTitle'][$GLOBALS['userlanguage']]:"";
    $error.=(strlen($review)<20)?$GLOBALS['dblang_shortMess'][$GLOBALS['userlanguage']]:"";
    $ip=$_SERVER[REMOTE_ADDR];
    if($error=="") {
        mysql_query("insert into ".$PREFIX."reviews set uname='$uname',umail='$umail',title='$title',review='$review',pubdate='".time()."',ip='$ip'"); //permittion
        $error=$GLOBALS['dblang_reviewThanks'][$GLOBALS['userlanguage']];
    }
}
render_to_template("components/reviews/tpl/error.php", array("error"=>$error));
$res=mysql_query("select * from ".$PREFIX."reviews where permittion=1");
while($row=mysql_fetch_assoc($res)){
    render_to_template("components/reviews/tpl/reviews.php", $row);
}
render_to_template("components/reviews/tpl/form.php", array("error"=>$error));
?>
