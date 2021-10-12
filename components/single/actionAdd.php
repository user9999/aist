<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
}
    //if (!isset($_GET['id'])) header("Location: " . $GLOBALS['PATH'] . "/404");
    set_title($GLOBALS['dblang_ctitle'][$GLOBALS['userlanguage']]);
    set_meta("", "");
    
    render_to_template("components/single/tpl/Header.php", array('title'=>$GLOBALS['dblang_ctitle'][$userlanguage],'menu'=>$GLOBALS['ssubmenu']));
$error="";
if($_POST['submit']) {
    $script=(strlen($_POST['script'])>3)?mysql_real_escape_string($_POST['script']):$error.=$GLOBALS['dblang_ErScript1'][$userlanguage];
    $info=(strlen($_POST['info'])>3)?mysql_real_escape_string($_POST['info']):$error.=$GLOBALS['dblang_ErInfo1'][$userlanguage];
    if($_SESSION['secpic']!=strtolower($_POST['secpic'])) {
        $error.=$GLOBALS['dblang_badcaptcha'][$userlanguage]."<br>";
    }
    if($error=="") {
        mysql_query("INSERT INTO `".$PREFIX."single` SET script='{$script}',info='{$info}'");
        $rel_id=$id=mysql_insert_id();

    } else {
        $error=$error.$multierror;
        $_POST['error']=$error;
        render_to_template("components/single/tpl/Form.php", $_POST['error']);
    }
    
} else {
    render_to_template("components/single/tpl/Form.php", array());
}

?>
