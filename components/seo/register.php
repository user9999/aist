<?php
session_start();
header("Content-Type: text/html; charset=windows-1251");
require_once("page.class.php");
require_once("contdisplay.php");
//require
if($_POST['submit']){
	if ($_SESSION['string'] != $_POST['code']){
		$target['<!--warn-->']="<p class=\"warn\">Неправильно введен код с картинки!</p>";
	} else {
		
	}
}
//target
require_once("news.class.php");
$new=new blocknews();
$target['<!--news-->']=$new->block("news");
$page=new page;
$context=new contdisplay;
$target['<!--rblock-->']=$context->display(10);
$target['<!--ban_price-->']=$page->ban_price;
$target['<!--title-->']="Сервис раскрутки сайтов";
$target['-@keywords@-']="";
$target['-@description@-']="";
$target['-@author@-']="Vlad";
$cont=$page->replace_file("index.tpl","menu,menu1,menu2,footer,content#register",$target);
print $cont;
?>