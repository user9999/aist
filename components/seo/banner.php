<?php
header("Content-Type: text/html; charset=windows-1251");
require_once("page.class.php");
require_once("contdisplay.php");
//require
if($_POST['addban']){
	require_once("mysql.class.php");
	$add=new mysql;
	$add->connect();
	$add->query_str="insert into banner values(NULL,2,'".$_POST['url']."','".$_POST['img']."','".$_POST['alt']."','".$_POST['width']."','".$_POST['height']."','".$_POST['amount']."','".md5($_POST['pass'])."',now())";
	$add->ms_query();
	$uid=mysql_insert_id();
	$add->ms_close();
	$target['<!--warn-->']="<p class=\"warn\">Запишите ваши данные для просмотра статистики:</p><p class=\"warn\"> id баннера - ".$uid.";</p><p class=\"warn\"> ваш пароль - ".$_POST['pass'];
}
switch($_GET['act']){
		case "rules":
			$aspage="banrules";
			break;
		case "ord":
			$aspage="ban_order";
			break;
		case "stat":
			$aspage="banstat";
			break;
		case "exchange":
			$aspage="banexchange";
			break;
		default:
			$aspage="banrules";
			break;

}
if($_POST['statistics']){
	require_once("mysql.class.php");
	$add=new mysql;
	$add->connect();
	$add->query_str="select id,url,img,alt,width,height,pass from banner where id=".$_POST['id'];
	$add->ms_query();
	$passw=mysql_fetch_row($add->query_result);
	if(md5($_POST['pass'])===$passw[6]){
		$add->query_str="select ip,date(visitdate),time(visitdate) from banstat where id_banner=".$_POST['id'];
		$add->ms_query();
		$target['<!--stat-->']="<table class=\"banstat\"><caption style=\"margin:auto;\"><b>Ваш баннер</b></caption><tr><td colspan=\"3\"><a href=\"".$passw[1]."\" target=\"_blank\"><img src=\"".$passw[2]."\" alt=\"".$passw[3]."\" width=\"".$passw[4]."\" height=\"".$passw[5]."\" /></a></td></tr>\n<tr><td>ip-адрес</td><td>Дата</td><td>Время</td></tr>\n";
		while($stat=mysql_fetch_row($add->query_result)){
			$target['<!--stat-->'].="<tr><td>".$stat[0]."</td><td>".$stat[1]."</td><td>".$stat[2]."</td></tr>\n";
		}
		$target['<!--stat-->'].="</table>";
	}
	$add->ms_close();
}
//target
$page=new page;
$context=new contdisplay;
$target['<!--enter-->']="<form method=post><input placeholder=login name=login>
<input type=password placeholder=password name=pass>
<input type=submit name=enter value=\"войти\"></form>
<a href=\"register.php\">Регистрация</a><br><a href=\"remember.php\">Напомнить пароль</a>";
$target['<!--rblock-->']=$context->display(10);
$target['<!--ban_price-->']=$page->ban_price;
$target['<!--title-->']="баннерная реклама";
$target['-@keywords@-']="баннеры, система обмена визитами, 468Х60";
$target['-@description@-']="баннерная реклама";
$target['-@author@-']="";
$cont=$page->replace_file("index.tpl","menu,menu1,menu2,footer,content#".$aspage,$target);
print $cont;
?>