<?php
session_start();
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//ini_set("display_errors", 1);
require "../inc/configuration.php";
require_once "../inc/functions.php";
require_once "../inc/lang.php";
$userlanguage=userlang();
if(file_exists("../inc/mail.templates.php")) {
    include_once "../inc/mail.templates.php";
}
if(file_exists("../inc/mail.system.templates.php")) {
    include_once "../inc/mail.system.templates.php";
}
$replacearray=array('{:sitetitle:}','{:url:}','{:password:}','{:username:}','{:userid:}','{:usermail:}','{:userdata:}','{:subscribe:}','{:unsubscribe:}','{:balance:}','{:refinvite:}','{:phone:}','{:birthdate:}','{:gender:}');

date_default_timezone_set('Europe/Moscow');

// User settings
//$robotmail="robot@iqrun.net";
$to = $ADMIN_EMAIL;//"user9999@rambler.ru";//"user9999@rambler.ru";$ADMIN_EMAIL
$subject = "Registration ".$PATH;
$refs=false;
// Include extra form fields and/or submitter data?
// false = do not include
$extra = array(
    "form_subject"    => false,
    "form_cc"        => false,
    "ip"            => true,
    "user_agent"    => true
);

// Process
$action = isset($_POST["action"]) ? $_POST["action"] : "";

if (empty($action)) {
    // Send back the contact form HTML

    $output = "<div style='display:none'>
	<div class='contact-top'></div>
	<div class='contact-content'>
		<h1 class='contact-title'>".$_GET['title']."</h1>
		<div class='contact-loading' style='display:none'></div>
		<div class='contact-message' style='display:none'></div>

		<form action='#' style='display:none'>

			<label for='contact-nick'>*".$GLOBALS['dblang_nick'][$userlanguage].":</label>
			<input type='text' id='contact-nick' class='contact-input' name='nick' tabindex='1001' />
			<label for='contact-email'>*".$GLOBALS['dblang_email'][$userlanguage].":</label>
			<input type='text' id='contact-email' class='contact-input' name='email' tabindex='1006' />
			<label for='contact-family'>".$GLOBALS['dblang_family'][$userlanguage].":</label>
			<input type='text' id='contact-family' class='contact-input' name='family' tabindex='1001' />

			
			<label for='contact-gender'>".$GLOBALS['dblang_gender'][$userlanguage].":</label>
			<div class=rbutton>".$GLOBALS['dblang_male'][$userlanguage]."&nbsp;&nbsp;&nbsp;<input type=radio class='contact-radio' name='gender' value=male></div>
			<div class=rbutton>".$GLOBALS['dblang_female'][$userlanguage]."&nbsp;&nbsp;&nbsp;<input type=radio class='contact-radio' name='gender' value=female></div>
			<!--<select id='contact-gender' class='contact-input' name='gender' tabindex='1004'>
			<option value=0>выбрать</option>
			<option value=male>мужской</option>
			<option value=female>женский</option>
			</select>-->
			
			<label for='contact-birthdate'>".$GLOBALS['dblang_byear'][$userlanguage].":</label>
			<input type='text' id='contact-birthdate' class='contact-input' name='birthdate' placeholder='".$GLOBALS['dblang_yyyy'][$userlanguage]."' tabindex='1005' />
			
			<!--<label for='contact-password'>*Пароль:</label>
			<input type='password' id='contact-password' class='contact-input' name='password' tabindex='1007' />-->
			<label for='contact-phone'>".$GLOBALS['dblang_phone'][$userlanguage].":</label>
			<input type='text' id='contact-phone' class='contact-input' name='phone' />
			<label for='contact-country'>".$GLOBALS['dblang_country'][$userlanguage].":</label>
			<input type='text' id='contact-country' class='contact-input' name='country' />
			<label for='contact-firm'>".$GLOBALS['dblang_firm'][$userlanguage].":</label>
			<input type='text' id='contact-firm' class='contact-input' name='firm' />
			<label for='contact-address'>".$GLOBALS['dblang_address'][$userlanguage].":</label>
			<input type='text' id='contact-address' class='contact-input' name='address' /><br/>";//дд.мм.гггг

    if ($extra["form_subject"]) {
        $output .= "
			<label for='contact-subject'>Subject:</label>
			<input type='text' id='contact-subject' class='contact-input' name='subject' value='' tabindex='1005' />";
    }
    /*
    $output .= "
    <label for='contact-message'>*Инвайт:</label>
    <div class=contact-input><input type='text' id='contact-message' class='contact-invite' name='invite' tabindex='1009' value='".$refinvite."' /> <span>предоставлен по умолчанию</span></div>
    <br/>";
    */
    $output .= "
			<label for='contact-secpic'>*".$GLOBALS['dblang_captcha'][$userlanguage].":</label>
			<input type='text' id='contact-secpic' class='contact-secpic' name='secpic' tabindex='1010' /> <img src=\"/secpic.php\" alt=\"защитный код\">
			<br/>";

    if ($extra["form_cc"]) {
        $output .= "
			<label>&nbsp;</label>
			<input type='checkbox' id='contact-cc' name='cc' value='1' tabindex='1005' /> <span class='contact-cc'>Send me a copy</span>
			<br/>";
    }

    $output .= "
			<label>&nbsp;</label>
			<button type='submit' class='contact-send contact-button' tabindex='1006'>".$GLOBALS['dblang_register'][$userlanguage]."</button>
			<!--<button type='submit' class='contact-cancel contact-button simplemodal-close' tabindex='1007'>Cancel</button>-->
			<br/>
			<input type='hidden' name='token' value='" . smcf_token($to) . "'/>
			<script>

			\$(\"#contact-birthdate\").mask(\"9999\",{placeholder:\"".$GLOBALS['dblang_yyyy'][$userlanguage]."\"});

			</script>
		</form>
	</div>
	<div class='contact-bottom'></div>
</div>";

    echo $output;

}else if ($action == "send") {

    // Send the email
    $nick = isset($_POST["nick"]) ? $_POST["nick"] : "";
    $family = isset($_POST["family"]) ? $_POST["family"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $gender = isset($_POST["gender"]) ? $_POST["gender"] : "";
    $birthdate = isset($_POST["birthdate"]) ? $_POST["birthdate"] : "";
    $phone = isset($_POST["phone"]) ? $_POST["phone"] : "";
    $country = isset($_POST["country"]) ? $_POST["country"] : "";
    $firm = isset($_POST["firm"]) ? $_POST["firm"] : "";
    $address = isset($_POST["address"]) ? $_POST["address"] : "";
    
    $cc = isset($_POST["cc"]) ? $_POST["cc"] : "";
    $token = isset($_POST["token"]) ? $_POST["token"] : "";

    // make sure the token matches
    if ($token === smcf_token($to)) {
        smcf_send($nick, $family, $email, $phone, $gender, $birthdate, $country, $firm, $address);
        echo $GLOBALS['dblang_messok'][$userlanguage];//"Your message was successfully sent.";
    }
    else {
        echo $GLOBALS['dblang_messerr'][$userlanguage];//"Unfortunately, your message could not be verified.";
    }
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
function smcf_token($s)
{
    return md5("smcf-" . $s . date("WY"));
}

function send_mail($type,$data)
{
    //,$name, $patronymic, $family, $email, $password,$from
    global $subject,$robotmail,$userlanguage,$PATH,$SITE_TITLE,$replacearray,$mailtemplates,$mailsystemtemplates;
    switch ($type){
    case "register"://'{:sitetitle:}','{:url:}','{:password:}','{:username:}','{:userid:}','{:usermail:}','{:userdata:}','{:subscribe:}','{:unsubscribe:}','{:balance:}','{:refinvite:}'
        $email=$data[2];
        $newvalues=array($SITE_TITLE[$userlanguage],$PATH,$data[3],$data[0],'',$data[2],'','','','','');
        $lettitle=str_replace($replacearray, $newvalues, $mailsystemtemplates['registration'][0]);
        $message=str_replace($replacearray, $newvalues, $mailsystemtemplates['registration'][1]);
        break;
    case "referal":
        $email=$data[0];
        $newvalues=array($SITE_TITLE[$userlanguage],$PATH,'',$data[1],$data[2],$data[0],'','','',$data[3],$data[4]);
        $lettitle=str_replace($replacearray, $newvalues, $mailtemplates['referal'][0]);
        $message=str_replace($replacearray, $newvalues, $mailtemplates['referal'][1]);
        //echo $message."referal";
        break;
    }
    //echo $robotmail."\n<br>";
    //echo $lettitle."\n<br>";
    //echo $email."\n<br>";
    //echo $message;
    $from=$robotmail;
    /*
    $ltitle="=?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $lettitle))."?=";
    $mess=iconv("UTF-8", "koi8-r", $message);
    //$headers="From: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $SITE_TITLE[$userlanguage]))."?= <".trim($from).">\r\nReply-to: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", "From"))."?= <".trim($from).">\r\nContent-type: text/html; charset=koi8-r\r\nContent-Transfer-Encoding: 8bit\r\n";//От кого
    //1
    //$headers = "From: \"".$SITE_TITLE[$userlanguage]."\" <robot@biorow.com>\n";
    //$headers .= "Content-type: text/plain; charset=\"utf-8\"";
    //2
    $headers = 'MIME-Version: 1.0' . "\n";
    $headers .= "From: \"".$SITE_TITLE[$userlanguage]."\" <robot@biorow.com>\n";
    $headers .= 'Content-type: text/html; charset=UTF-8';
    
    $ltitle='=?UTF-8?B?'.base64_encode($lettitle).'?=';
    //$mess=$message;
    mail($email,$ltitle,$mess,$headers);
    */
    ini_set("sendmail_from", $from);
    mail($email, $lettitle, $message, "From: <" . $from . "> -f" . $from) or     die("Unfortunately, a server issue prevented delivery of your message.");
    //echo "mail('".$email."','".$lettitle."','". $message."',\"From: < ". $from ."> -f". $from." );";
    //var_dump($email);echo "\n\n";
    //var_dump($lettitle);echo "\n\n";
    //var_dump($message);echo "\n\n";
    //var_dump($from);
    
    //echo $SITE_TITLE[$userlanguage]."\n<br>";
    //echo $headers."\n<br>";
    //echo $ltitle."\n<br>";
    //echo $message;
}
function register_user($nick, $family, $email, $phone, $gender,$birthdate,$country,$firm,$address)
{
    global $level,$BONUS,$userlanguage;
    
    $password=gen_pass();
    //echo "insert into ".$GLOBALS['PREFIX']."users SET nick='$nick',email='$email',phone='$phone',name='$family', gender='$gender', birthdate='$birthdate',country='$country',firm='$firm',address='$address',password='".md5($password)."',regdate=".time();
    mysql_query("insert ".$GLOBALS['PREFIX']."into users SET nick='$nick',email='$email',phone='$phone',name='$family', gender='$gender', birthdate='$birthdate',country='$country',firm='$firm',address='$address',password='".md5($password)."',regdate=".time());
    //echo "insert into ".$GLOBALS['PREFIX']."users SET nick='$nick',email='$email',phone='$phone',name='$family', gender='$gender', birthdate='$birthdate',country='$country',firm='$firm',address='$address',password='".md5($password)."',regdate=".time();
    send_mail("register", array($nick, $family, $email, $password));// or     die("Unfortunately, a server issue prevented delivery of your message.");
    die($GLOBALS['dblang_regsuccess'][$userlanguage]);//"Вы зарегистрированы. Пароль отправлен на Ваш email."

}
function check_base($email)
{
    //global $level;
    $mess="";
    $res=mysql_query("select id from ".$GLOBALS['PREFIX']."users where email='{$email}'");
    if(mysql_num_rows($res)>0) {
        $mess=$GLOBALS['dblang_userexist'][$userlanguage];//"Такой участник уже есть в базе!";
    }
    return $mess;
}
// Validate and send email
function smcf_send($nick, $family, $email, $phone, $gender,$birthdate,$country,$firm,$address)
{

    global $to, $extra,$refs;
    $message=$address;
    // Filter and validate fields
    $nick = mysql_real_escape_string(smcf_filter($nick));
    $family = mysql_real_escape_string(smcf_filter($family));
    $email = smcf_filter($email);
    $phone = smcf_filter($phone);
    $country = mysql_real_escape_string(smcf_filter($country));
    $firm = mysql_real_escape_string(smcf_filter($firm));
    $address = mysql_real_escape_string(smcf_filter($address));
    $mess="";
    if($_SESSION['secpic']!=strtolower($_POST['secpic'])) {
        $mess.=$GLOBALS['dblang_badcaptcha'][$userlanguage]."<br>";//"Неверно введен проверочный код.<br>";
    }
    if(strlen($nick)<2) {
        $mess.=$GLOBALS['dblang_checknick'][$userlanguage]."<br>";//"Укажите Ник.<br>";
    }

    if (!smcf_validate_email($email)) {
        $subject .= " - invalid email";
        $message .= "\n\nBad email: $email";
        $email = $to;
        $cc = 0; // do not CC "sender"
        $mess.=$GLOBALS['dblang_badmail'][$userlanguage]."<br>";//"Некорректный email.<br>";
    }
    if($mess=="") {
        $newmess=check_base($email);
        
        if($newmess=="") {
            register_user($nick, $family, $email, $phone, $gender, $birthdate, $country, $firm, $address);
        } elseif($newmess && $refs) {
            echo $newmess." ".$refs[0];
            die();
        } else {
            die($newmess);        
        }
    
    } else {
        die($mess);
    }
    /*
    // Add additional info to the message
    if ($extra["ip"]) {
    $message .= "\n\nIP: " . $_SERVER["REMOTE_ADDR"];
    }
    if ($extra["user_agent"]) {
    $message .= "\n\nUSER AGENT: " . $_SERVER["HTTP_USER_AGENT"];
    }

    // Set and wordwrap message body
    $body = "From: $name\n\n";
    $body .= "Message: $message";
    $body = wordwrap($body, 70);

    // Build header
    $headers = "From: $email\n";
    if ($cc == 1) {
    $headers .= "Cc: $email\n";
    }
    $headers .= "X-Mailer: PHP/SimpleModalContactForm";

    // UTF-8
    if (function_exists('mb_encode_mimeheader')) {
    $subject = mb_encode_mimeheader($subject, "UTF-8", "B", "\n");
    }
    else {
    // you need to enable mb_encode_mimeheader or risk 
    // getting emails that are not UTF-8 encoded
    }
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/plain; charset=utf-8\n";
    $headers .= "Content-Transfer-Encoding: quoted-printable\n";

    
    
    // Send email
    @mail($to, $subject, $body, $headers) or 
    die("Unfortunately, a server issue prevented delivery of your message.");
    */
}

// Remove any un-safe values to prevent email injection
function smcf_filter($value)
{
    $pattern = array("/\n/","/\r/","/content-type:/i","/to:/i", "/from:/i", "/cc:/i");
    $value = preg_replace($pattern, "", $value);
    return $value;
}
function smcf_validate_phone($phone)
{
    if(preg_match("!^[ 0-9)(\-\+]+$!is", $phone, $match)) {
        return true;
    } else {
        return false;
    }
}
function smcf_validate_birthdate($birthdate)
{
    if(preg_match("!^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$!is", $birthdate, $match)) {
        return true;
    } else {
        return false;
    }
}
// Validate email address format in case client-side validation "fails"
function smcf_validate_email($email)
{
    $at = strrpos($email, "@");

    // Make sure the at (@) sybmol exists and  
    // it is not the first or last character
    if ($at && ($at < 1 || ($at + 1) == strlen($email))) {
        return false;
    }

    // Make sure there aren't multiple periods together
    if (preg_match("/(\.{2,})/", $email)) {
        return false;
    }

    // Break up the local and domain portions
    $local = substr($email, 0, $at);
    $domain = substr($email, $at + 1);


    // Check lengths
    $locLen = strlen($local);
    $domLen = strlen($domain);
    if ($locLen < 1 || $locLen > 64 || $domLen < 4 || $domLen > 255) {
        return false;
    }

    // Make sure local and domain don't start with or end with a period
    if (preg_match("/(^\.|\.$)/", $local) || preg_match("/(^\.|\.$)/", $domain)) {
        return false;
    }

    // Check for quoted-string addresses
    // Since almost anything is allowed in a quoted-string address,
    // we're just going to let them go through
    if (!preg_match('/^"(.+)"$/', $local)) {
        // It's a dot-string address...check for valid characters
        if (!preg_match('/^[-a-zA-Z0-9!#$%*\/?|^{}`~&\'+=_\.]*$/', $local)) {
            return false;
        }
    }

    // Make sure domain contains only valid characters and at least one period
    if (!preg_match("/^[-a-zA-Z0-9\.]*$/", $domain) || !strpos($domain, ".")) {
        return false;
    }    

    return true;
}

exit;

?>
