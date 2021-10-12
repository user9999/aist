<?php
session_start();
/*
 * SimpleModal Contact Form
 * http://simplemodal.com
 *
 * Copyright (c) 2013 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 */
require "../inc/configuration.php";
require_once "../inc/functions.php";
require_once "../inc/lang.php";
$userlanguage=userlang();
date_default_timezone_set('Europe/Moscow');

// User settings
$to = $ADMIN_EMAIL;//"user9999@rambler.ru";
$subject = "SimpleModal Contact Form";

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
		<h1 class='contact-title'>".$GLOBALS['dblang_enter'][$userlanguage].":</h1>
		<div class='contact-loading' style='display:none'></div>
		<div class='contact-message' style='display:none'></div>
		<form action='#' style='display:none'>
			<label for='contact-email'>*".$GLOBALS['dblang_email'][$userlanguage].":</label>
			<input type='text' id='contact-email' class='contact-input' name='email' tabindex='1002' />
			<label for='contact-phone'>*".$GLOBALS['dblang_password'][$userlanguage].":</label>
			<input type='password' id='contact-password' class='contact-input' name='password' tabindex='1004' />";


    if ($extra["form_subject"]) {
        $output .= "
			<label for='contact-subject'>Subject:</label>
			<input type='text' id='contact-subject' class='contact-input' name='subject' value='' tabindex='1005' />";
    }
    /*
    $output .= "<br>
    <label for='contact-secpic'>*".$GLOBALS['dblang_captcha'][$userlanguage]." :</label>
    <input type='text' id='contact-secpic' class='contact-secpic' name='secpic' tabindex='1010' /> <img src=\"/secpic.php\" alt=\"защитный код\">
    <br/>";
    */
    if ($extra["form_cc"]) {
        $output .= "
			<label>&nbsp;</label>
			<input type='checkbox' id='contact-cc' name='cc' value='1' tabindex='1005' /> <span class='contact-cc'>Send me a copy</span>
			<br/>";
    }

    $output .= "<br>
			<label>&nbsp;</label>
			<button type='submit' class='contact-send contact-button' tabindex='1006'>".$GLOBALS['dblang_enter'][$userlanguage]."</button>
			<!--<button type='submit' class='contact-cancel contact-button simplemodal-close' tabindex='1007'>Закрыть</button>-->
			<br/>
			<input type='hidden' name='token' value='" . smcf_token($to) . "'/><a class=restore href='/restore'>".$GLOBALS['dblang_restore'][$userlanguage]."</a>
		</form>
		
	</div>
	<div class='contact-bottom'></div>
</div>";

    echo $output;
}
else if ($action == "send") {
    // Send the email
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    
    $phone = isset($_POST["phone"]) ? $_POST["phone"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    
    $subject = isset($_POST["subject"]) ? $_POST["subject"] : $subject;
    $message = isset($_POST["message"]) ? $_POST["message"] : "";
    $cc = isset($_POST["cc"]) ? $_POST["cc"] : "";
    $token = isset($_POST["token"]) ? $_POST["token"] : "";

    // make sure the token matches
    if ($token === smcf_token($to)) {
        smcf_send($name, $email, $subject, $message, $cc, $phone, $password);
        echo "Your message was successfully sent.";
    }
    else {
        echo "Unfortunately, your message could not be verified.";
    }
}

function smcf_token($s)
{
    return md5("smcf-" . $s . date("WY"));
}

// Validate and send email
function smcf_send($name, $email, $subject, $message, $cc,$phone,$password)
{
    global $to, $extra, $userlanguage;

    // Filter and validate fields
    //$name = mysql_real_escape_string(smcf_filter($name));
    //$subject = mysql_real_escape_string(smcf_filter($subject));
    $email = smcf_filter($email);
    //$phone = smcf_filter($phone);
    $mess="";
    //if($_SESSION['secpic']!=strtolower($_POST['secpic'])){
    //    $mess.=$GLOBALS['dblang_badcaptcha'][$userlanguage].".<br>";
    //}
    if (!smcf_validate_email($email)) {
        $subject .= " - invalid email";
        $message .= "\n\nBad email: $email";
        $email = $to;
        $cc = 0; // do not CC "sender"
        $mess.=$GLOBALS['dblang_badmail'][$userlanguage].".<br>";
    }
    if($mess=="") {
        $res=mysql_query("select id,nick,email,password from ".$GLOBALS['PREFIX']."users where email='".$email."' and password='".md5($password)."' limit 1");
        if(mysql_num_rows($res)) {//mysql_query("insert into users SET email='$email',phone='$phone',name='$name',address='$message',password='".md5($password)."'")){
            //echo "insert into users SET email='$email',phone='$phone',name='$name',address='$message',password=ENCODE('$password','".$GLOBALS['SECRET_KEY']."')";
            $row=mysql_fetch_row($res);
            $_SESSION['userid']=$row[0];
            $_SESSION['nick']=$row[1];
            $_SESSION['email']=$row[2];
            //header("Location:".$GLOBALS['PATH']);
            die("OK");
        } else {
            die($GLOBALS['dblang_notfound'][$userlanguage]."<br>");
        }
    } else {
        die($mess);
    }

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
