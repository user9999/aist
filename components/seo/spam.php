<?php
header("Content-Type: text/html; charset=windows-1251");
require_once("page.class.php");
require_once("contdisplay.php");
require_once("session.class.php");
require_once("mysql.class.php");
//require
$session=new session;
if(!$session->session_true()){
	include_once("spamfront.php");
	
}
if($session->session_true()){
	include_once("spamacc.php");
	acc();
}
if($spam){///////////////////////////////////////ѕодключение.......
	$ip=implode("",file(SECRET_DIR."remote"));
	require_once("ping.php");
	$time_conn = $HTTP_POST_VARS ["timeout"];
	$ping = new Net_Ping;
	$ping->ping($ip);
	$target['<!--server-->']="<p class=\"warn\">¬ данный момент сервис недоступен, оставьте заказ, как только сервис заработает заказ автоматически будет обработан</p>";

	if ($ping->time){
		if($fp=@fopen("http://".$ip."/spammer/index.html","rb")){
			while(!feof($fp)) {
				$servcont .= fread($fp,4096);
			}
    			fclose($fp);
			if(eregi("spammer ready",$servcont)){
				$target['<!--server-->']="<p class=\"warn\">—памер включен</p>";
			} else {
				$target['<!--server-->']="<p class=\"warn\">¬ данный момент сервис недоступен, оставьте заказ, как только сервис заработает заказ автоматически будет обработан</p>";
			}
		} else {
			$target['<!--server-->']="<p class=\"warn\">¬ данный момент сервис недоступен, оставьте заказ, как только сервис заработает заказ автоматически будет обработан</p>";
		}
	} else {
	$target['<!--server-->']="<p class=\"warn\">¬ данный момент сервис недоступен, оставьте заказ, как только сервис заработает заказ автоматически будет обработан</p>";

	}
}
///////////////////////////////////////ѕодключение.......
//target
$page=new page;
$context=new contdisplay;
$target['<!--rblock-->']=$context->display(10);
$target['<!--ban_price-->']=$page->ban_price;
$target['<!--title-->']=" онтекстна€ реклама";
$target['-@keywords@-']=" онтекстна€ реклама, баннеры, система обмена визитами";
$target['-@description@-']="баннерна€ реклама";
$target['-@author@-']="";
$cont=$page->replace_file("index.tpl","menu,".$enter.",menu1,menu2,footer,content#".$aspage,$target);
print $cont;
?>