<?php if (!defined("SIMPLE_CMS")) {
    die("Access denied");
}
    //if (!isset($_GET['id'])) header("Location: " . $GLOBALS['PATH'] . "/404");
    set_title($GLOBALS['dblang_ctitle'][$GLOBALS['userlanguage']]);
    set_meta("", "");
    $script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>";
set_script($script);
    render_to_template("components/product/tpl/Header.php", array('title'=>$GLOBALS['dblang_ctitle'][$userlanguage],'menu'=>$GLOBALS['ssubmenu']));
$error="";
if ($_POST['submit']) {
    $pid=(strlen($_POST['pid'])>3)?mysql_real_escape_string($_POST['pid']):$error.=$GLOBALS['dblang_ErPid1'][$userlanguage];
    $name=(strlen($_POST['name'])>3)?mysql_real_escape_string($_POST['name']):$error.=$GLOBALS['dblang_ErName1'][$userlanguage];
    $alias=(strlen($_POST['alias'])>3)?mysql_real_escape_string($_POST['alias']):$error.=$GLOBALS['dblang_ErAlias1'][$userlanguage];
    $text=(strlen($_POST['text'])>3)?mysql_real_escape_string($_POST['text']):$error.=$GLOBALS['dblang_ErText1'][$userlanguage];
    $price=(strlen($_POST['price'])>3)?mysql_real_escape_string($_POST['price']):$error.=$GLOBALS['dblang_ErPrice1'][$userlanguage];
    if ($_SESSION['secpic']!=strtolower($_POST['secpic'])) {
        $error.=$GLOBALS['dblang_badcaptcha'][$userlanguage]."<br>";
    }
    if ($error=="") {
        mysql_query("INSERT INTO `".$PREFIX."product` SET pid='{$pid}',name='{$name}',alias='{$alias}',text='{$text}',price='{$price}'");
        $rel_id=$id=mysql_insert_id();
        $language=$GLOBALS['userlanguage'];
        $title=mysql_real_escape_string($_POST['title'][$language]);
        $short=mysql_real_escape_string($_POST['short'][$language]);
        $content=mysql_real_escape_string($_POST['content'][$language]);
        $description=mysql_real_escape_string($_POST['description'][$language]);
        $keywords=mysql_real_escape_string($_POST['keywords'][$language]);
        $pub_date=(strlen($_POST['pub_date'][$language])>6)?strtotime($_POST['pub_date'][$language]):time();
        mysql_query("INSERT INTO `".$PREFIX."lang_text` SET rel_id={$rel_id} ,table_name='product',language='{$language}',title='{$title}',short='{$short}',content='{$content}',description='{$description}',keywords='{$keywords}',pub_date='{$pub_date}'");
        $error=$GLOBALS['dblang_done'][$GLOBALS['userlanguage']];
        render_to_template("components/product/tpl/Form.php", array('error'=>$error));
    //}
    } else {
        $error=$error.$multierror;
        $_POST['error']=$error;
        render_to_template("components/product/tpl/Form.php", $_POST['error']);
    }
} else {
    render_to_template("components/product/tpl/Form.php", array());
}
