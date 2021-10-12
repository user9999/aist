<?php
//header("Content-Type: text/html; charset=windows-1251");
require_once("vars.class.php");
require_once("headers.php");
require_once("page.class.php");
require_once("contdisplay.php");
//require
//target
require_once("news.class.php");
$new=new blocknews();
$target['<!--news-->']=$new->block("news");
$page=new page;
$context=new contdisplay;
/*
$target['<!--enter-->']="<form method=post><input placeholder=login name=login>
<input type=password placeholder=password name=pass>
<input type=submit name=enter value=\"войти\"></form>
<a href=\"register.php\">Регистрация</a><br><a href=\"remember.php\">Напомнить пароль</a>";
*/
$target['-SITE_ADDR-']=$context->PATH_HTTP;
$target['<!--rblock-->']=$context->display(10);
$target['<!--ban_price-->']=$page->ban_price;
$target['<!--title-->']="SEO сервис";
$target['-@keywords@-']="";
$target['-@description@-']="";
$target['-@author@-']="Vlad";
$cont=$page->replace_file("index.tpl","menu,menu1,menu2,enter,footer,content#page",$target);
$headers=new headers();
$headers->output();
print $cont;
?>