<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
//echo "here!!!!";
if(file_exists($HOSTPATH."/inc/mail.templates.php")) {
    include_once $HOSTPATH."/inc/mail.templates.php";
}
function gen_pass()
{
    $chars="qazxswedcvfrtgbnhyujmkp23456789QAZXSWEDCVFRTGBNHYUJMKLP"; 
    $max=9; 
    $size=StrLen($chars)-1; 
    $password=null; 
    while($max--) { 
        $password.=$chars[rand(0, $size)];
    } 
    return $password;
}
function send_mail($type,$data)
{
    //,$name, $patronymic, $family, $email, $password,$from
    global $subject,$robotmail,$PATH,$userlanguage,$SITE_TITLE,$replacearray,$mailtemplates,$mailsystemtemplates;
    //echo $type;
    switch ($type){
    case "referal":
        $email=$data[0];
        $newvalues=array($SITE_TITLE[$GLOBALS[userlanguage]],$PATH,'',$data[1],$data[2],$data[0],'','','',$data[3],$data[4]);
        $lettitle=str_replace($replacearray, $newvalues, $mailtemplates['referal'][0]);
        $message=str_replace($replacearray, $newvalues, $mailtemplates['referal'][1]);
        //echo $message."referal";
        break;
    case "restore":
        $email=$data[0];
        $newvalues=array($SITE_TITLE[$GLOBALS[userlanguage]],$PATH,'',$data[1],'',$data[0],'',$data[2],'','','');
        $lettitle=str_replace($replacearray, $newvalues, $mailtemplates['restore'][0]);
        $message=str_replace($replacearray, $newvalues, $mailtemplates['restore'][1]);
        //var_dump($mailtemplates['restore']);
        //echo $message."!!!!";
        //die();
        break;
    }

    
    $from=$robotmail;
    $ltitle="=?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $lettitle))."?=";
    $mess=iconv("UTF-8", "koi8-r", $message);
    $headers="From: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $SITE_TITLE[$GLOBALS[userlanguage]]))."?= <".trim($from).">\r\nReply-to: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", "От кого"))."?= <".trim($from).">\r\nContent-type: text/html; charset=koi8-r\r\nContent-Transfer-Encoding: 8bit\r\n";
    mail($email, $ltitle, $mess, $headers);
}
$message='';

if($_POST['mail']) {
    $mail=mysql_real_escape_string($_POST['mail']);
    $res=mysql_query('select email,name from '.$PREFIX.'users where email="'.$mail.'" limit 1');
    if(mysql_num_rows($res)==1) {
        //добаить в базу количество реф не более3 от системы
        $row=mysql_fetch_row($res);
        $code=gen_pass();
        $code=md5($code);
        mysql_query('update '.$PREFIX.'users set tmp_pass="'.$code.'" where email="'.$mail.'"');
        $link=$PATH."/restore?user=".urlencode($row[0])."&code=".$code;
        send_mail('restore', array($row[0],$row[1],$link));
        $message="<div class=error>".$GLOBALS['dblang_restoreSend'][$GLOBALS['userlanguage']]."</div>";//Ссылка для восстановления пароля отправлена Вам на почту.
    } else {
        $message="<div class=error>".$GLOBALS['dblang_nouser'][$GLOBALS['userlanguage']]."</div>";//Участника с таким адресом в системе нет!
    }
}
if($_POST['password'] && $_POST['code']) {
    $code=mysql_real_escape_string($_GET['code']);
    if(strlen($_POST['password'])<6) {
        $message="<div class=error>".$GLOBALS['dblang_minPass'][$GLOBALS['userlanguage']]."</div>";//Минимальная длина пароля не менее 6 символов!
    } else {
        mysql_query('update '.$PREFIX.'users set password="'.md5($_POST['password']).'", tmp_pass="" where tmp_pass="'.$code.'"');
        //echo 'update user set password="'.md5($_POST['password']).'" tmp_pass="" where tmp_pass="'.$code.'"';
        $message="<div class=error>".$GLOBALS['dblang_passChanged'][$GLOBALS['userlanguage']]."</div>";//Пароль изменен!
    }
}
echo $message;
if($_GET['user'] && $_GET['code']) {
    $user=urldecode($_GET['user']);
    $user=mysql_real_escape_string($user);
    $code=mysql_real_escape_string($_GET['code']);
    $res=mysql_query('select id from '.$PREFIX.'users where email="'.$user.'" and tmp_pass="'.$code.'"limit 1');
    if(mysql_num_rows($res)===1) {

        ?>
<form method="post"><table class=restore><caption><?php echo $GLOBALS['dblang_passRecovery'][$GLOBALS['userlanguage']]; ?></caption>
<tr><td><label for='restore-input' style='width: 230px;'><?php echo $GLOBALS['dblang_newPass'][$GLOBALS['userlanguage']]; ?></label></td><td><input type="text" id='restore-input' class='restore-input' name="password" /></td></tr>
<tr><td><input type=hidden name=code value='<?php echo $code;?>'></td><td><input type="submit" name="button" value="<?php echo $GLOBALS['dblang_restoreButton'][$GLOBALS['userlanguage']]; ?>" class="button" /></td></tr> 
</table> 
</form>
        <?php
    } elseif(!$_POST['code']) {
        echo "<div class=error>".$GLOBALS['dblang_wrongLink'][$GLOBALS['userlanguage']]."</div>";
    }
} else {
    ?>

<form method="post"><table class=restore><caption><?php echo $GLOBALS['dblang_passRecovery'][$GLOBALS['userlanguage']]; ?></caption>
<tr><td><label for='restore-input'><?php echo $GLOBALS['dblang_umail'][$GLOBALS['userlanguage']]; ?></label></td><td><input type="text" id='restore-input' class='restore-input' name="mail" /></td></tr>
<tr><td></td><td><input type="submit" name="button" value="<?php echo $GLOBALS['dblang_restoreButton'][$GLOBALS['userlanguage']]; ?>" class="button" /></td></tr> 
</table> 
</form>
    <?php
}
?>
