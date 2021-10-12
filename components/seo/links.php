<?php
header("Content-Type: text/html; charset=windows-1251");
require_once("page.class.php");
require_once("contdisplay.php");
//require
//target
require_once("news.class.php");
$new=new blocknews();
$target['<!--news-->']=$new->block("news");
$page=new page;
$context=new contdisplay;
$target['<!--enter-->']="<form method=post><input placeholder=login name=login>
<input type=password placeholder=password name=pass>
<input type=submit name=enter value=\"войти\"></form>
<a href=\"register.php\">Регистрация</a><br><a href=\"remember.php\">Напомнить пароль</a>";
$target['<!--rblock-->']=$context->display(10);
$target['<!--ban_price-->']=$page->ban_price;
$target['<!--title-->']="Сервис раскрутки сайтов";
$target['-@keywords@-']="";
$target['-@description@-']="";
$target['-@author@-']="Vlad";
$cont=$page->replace_file("index.tpl","menu,menu1,menu2,footer,content#frontlinks",$target);
print $cont;
?>