<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
set_title("Кабинет");
require_once "inc/mail.system.templates.php";
$res=mysql_query("select * from ".$PREFIX."users where id='".$_SESSION['userid']."' limit 1");
$row=mysql_fetch_array($res);
$replacearray=array('{:sitetitle:}','{:url:}','{:username:}','{:usermail:}','{:userpercent:}','{:usermoney:}','{:useramount:}','{:userdata:}','{:actions:}');
$newvalues=array($PAGE_TITLE,$PATH,$_SESSION['user_name'],$row['email'],$row['percent'],$row['money'],$row['amount'],$row['udata'],'');
$umess=str_replace($replacearray, $newvalues, $mailsystemtemplates['index'][1]);  
echo $umess;
?>
