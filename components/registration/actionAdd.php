<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
}
    //if (!isset($_GET['id'])) header("Location: " . $GLOBALS['PATH'] . "/404");
    set_title($GLOBALS['dblang_ctitle'][$GLOBALS['userlanguage']]);
    set_meta("", "");
    $script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>";
set_script($script);
    render_to_template("components/registration/tpl/Header.php", array('title'=>$GLOBALS['dblang_ctitle'][$userlanguage],'menu'=>$GLOBALS['ssubmenu']));
$error="";
if($_POST['submit']) {
    if($_SESSION['secpic']!=strtolower($_POST['secpic'])) {
        $error.=$GLOBALS['dblang_badcaptcha'][$userlanguage]."<br>";
    }
    if($error=="") {
        mysql_query("INSERT INTO `".$PREFIX."` SET");
        $rel_id=$id=mysql_insert_id();
        $language=$GLOBALS['userlanguage'];
        $nick=mysql_real_escape_string($_POST['nick'][$language]);
        $parent_id=mysql_real_escape_string($_POST['parent_id'][$language]);
        $email=mysql_real_escape_string($_POST['email'][$language]);
        $phone=mysql_real_escape_string($_POST['phone'][$language]);
        $name=mysql_real_escape_string($_POST['name'][$language]);
        $gender=mysql_real_escape_string($_POST['gender'][$language]);
        $birthdate=mysql_real_escape_string($_POST['birthdate'][$language]);
        $country=mysql_real_escape_string($_POST['country'][$language]);
        $firm=mysql_real_escape_string($_POST['firm'][$language]);
        $password=mysql_real_escape_string($_POST['password'][$language]);
        $actype=mysql_real_escape_string($_POST['actype'][$language]);
        $percent=mysql_real_escape_string($_POST['percent'][$language]);
        $udata=mysql_real_escape_string($_POST['udata'][$language]);
        $money=mysql_real_escape_string($_POST['money'][$language]);
        $amount=mysql_real_escape_string($_POST['amount'][$language]);
        $level=mysql_real_escape_string($_POST['level'][$language]);
        $ref_amount=mysql_real_escape_string($_POST['ref_amount'][$language]);
        $points=mysql_real_escape_string($_POST['points'][$language]);
        $regdate=mysql_real_escape_string($_POST['regdate'][$language]);
        $ref2_amount=mysql_real_escape_string($_POST['ref2_amount'][$language]);
        $ref3_amount=mysql_real_escape_string($_POST['ref3_amount'][$language]);
        $ref4_amount=mysql_real_escape_string($_POST['ref4_amount'][$language]);
        $getref=mysql_real_escape_string($_POST['getref'][$language]);
        $systemref=mysql_real_escape_string($_POST['systemref'][$language]);
        $tmp_pass=mysql_real_escape_string($_POST['tmp_pass'][$language]);
        $package=mysql_real_escape_string($_POST['package'][$language]);
        $payed_till=mysql_real_escape_string($_POST['payed_till'][$language]);

        mysql_query("INSERT INTO `".$PREFIX."users` SET rel_id={$rel_id} ,nick='{$nick}',parent_id='{$parent_id}',email='{$email}',phone='{$phone}',name='{$name}',gender='{$gender}',birthdate='{$birthdate}',country='{$country}',firm='{$firm}',password='{$password}',actype='{$actype}',percent='{$percent}',udata='{$udata}',money='{$money}',amount='{$amount}',level='{$level}',ref_amount='{$ref_amount}',points='{$points}',regdate='{$regdate}',ref2_amount='{$ref2_amount}',ref3_amount='{$ref3_amount}',ref4_amount='{$ref4_amount}',getref='{$getref}',systemref='{$systemref}',tmp_pass='{$tmp_pass}',package='{$package}',payed_till='{$payed_till}'");
        $error=$GLOBALS['dblang_done'][$GLOBALS['userlanguage']];
        render_to_template("components/registration/tpl/Form.php", array('error'=>$error));
        //}

    } else {
        $error=$error.$multierror;
        $_POST['error']=$error;
        render_to_template("components/registration/tpl/Form.php", $_POST['error']);
    }
    
} else {
    render_to_template("components/registration/tpl/Form.php", array());
}

?>
