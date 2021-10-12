<?php
header("Content-Type: text/html; charset=windows-1251");
require_once("page.class.php");
require_once("session.class.php");
require_once("mysql.class.php");
require_once("contdisplay.php");
//require
$session=new session;
if(!$session->session_true()){
	$aspage="/unauth_1";
	if($_POST['enter']){
		$session->session_begin($_POST['login'],$_POST['pass']);
		

	}
	switch($_GET['act']){
		case "register":
			$aspage="/register";
			break;
		case "remember":
			$aspage="/remember_1";
			break;
		case "rules":
			$aspage="asurfrules";
			break;
		case "ord":
			$aspage="asurforder";
			break;
		case "stat":
			$aspage="asurfstat";
			break;
		case "surf":
			$aspage="asurf";
			break;
		default:
			$aspage="asurfrules";
			break;

	}
$target['<!--enter-->']="<form method=post><input placeholder=login name=login>
<input type=password placeholder=password name=pass>
<input type=submit name=enter value=\"войти\"></form>
<a href=\"?act=register\">Регистрация</a><br><a href=\"?act=remember\">Напомнить пароль</a>";
}
if($session->session_true()){
	require_once "dbquery.class.php";
	$display=new dbquery;
	switch($_REQUEST['action']){
	case "add":
		$display->add_user();
		break;
	case "update":
		$display->update_user();
		$target['<!--results-->']=$display->select_user("<td><!--login--></td><td><!--pass--></td><td><input type='submit' name='add[<!--id-->]' value='Добавить' /></td></tr>\r\n");
		$newact="display";
		break;
	case "del":
		if($_POST['del']){
			$display->del_user();
			$target['<!--results-->']=$display->select_user("<td><!--login--></td><td><!--pass--></td><td><input type='submit' name='add[<!--id-->]' value='Добавить' /></td></tr>\r\n");
		}else if($_POST['edit']){
			$target=$display->select_user("<td><!--login--></td><td><!--pass--></td><td><input type='submit' name='add[<!--id-->]' value='Добавить' /></td></tr>\r\n",$_POST['edit'],"edit");
			$newact="update";
		}
		break;
	case "search":
		$target['<!--results-->']=$display->search_user();
		break;
	default:
		$target['<!--results-->']=$display->select_user("<td><!--login--></td><td><!--pass--></td><td><!--email--></td><td><input type='submit' name='add[<!--id-->]' value='Добавить' /></td></tr>\r\n");
		break;
	}
	$act=($newact)?$newact:$_GET['act'];
	switch ($act){
	case "search":
		$target['<!--hidden-->']="<input type=\"hidden\" name=\"action\" value=\"search\" />";
		$aspage="/searchpage_1";
		break;
	case "display":
		$target['<!--hidden-->']="<input type=\"hidden\" name=\"action\" value=\"display\" />";
		$aspage="/showpage_1";
		break;
	case "del":
		$target['<!--hidden-->']="<input type=\"hidden\" name=\"action\" value=\"display\" />";
		$aspage="/showpage_1";
		break;
	case "add":
		$target['<!--hidden-->']="<input type=\"hidden\" name=\"action\" value=\"add\" />";
		$aspage="/addpage_1";
		break;
	case "update":
		$target['<!--hidden-->']="<input type=\"hidden\" name=\"action\" value=\"update\" /><input type=\"hidden\" name=\"id\" value=\"".$target['--id--']."\" />";
		$aspage="/addpage_1";
		break;
	default:
		$target['<!--hidden-->']="<input type=\"hidden\" name=\"action\" value=\"display\" />";
		$aspage="/showpage_1";
		break;
	}
	$target['<!--enter-->']="Аккаунт ".$_SESSION['logged']."<br /><form method=\"post\"><input type=\"submit\" name=\"logout\" value=\"выйти\"></form>";
	if($_POST['logout']){
		unset($_SESSION);
		session_destroy();
$target['<!--enter-->']="<form method=post>Логин<input name=login>
Пароль<input type=password name=pass>
<input type=submit name=enter value=\"войти\"></form>
<a href=\"register.php\">Регистрация</a><br><a href=\"remember.php\">Напомнить пароль</a>";
		$aspage="/unauth_1";
	}
}
if($_POST['statistics']){
	require_once("mysql.class.php");
	$add=new mysql;
	$add->connect();
	$add->query_str="select id,url,cash,credits,duration,pass from asurf where id=".$_POST['id'];
	$add->ms_query();
	$passw=mysql_fetch_row($add->query_result);
	if(md5($_POST['pass'])===$passw[5]){
		$add->query_str="select ip,date(visitdate),time(visitdate) from asurfstat where id_site=".$_POST['id'];
		$add->ms_query();
		$target['<!--stat-->']="<table class=\"banstat\"><caption style=\"margin:auto;\"><b>Ваш сайт</b> - <a href=\"".$passw[1]."\" target=\"_blank\">".$passw[1]."</a></caption><tr><td colspan=\"3\">Осталось на счету ".$passw[2]."$ и ".$passw[3]." кредитов, время просмотра - ".$passw[4]." секунд.</td></tr>\n<tr><td>ip-адрес</td><td>Дата</td><td>Время</td></tr>\n";
		while($stat=mysql_fetch_row($add->query_result)){
			$target['<!--stat-->'].="<tr><td>".$stat[0]."</td><td>".$stat[1]."</td><td>".$stat[2]."</td></tr>\n";
		}
		$target['<!--stat-->'].="</table>";
	}
	$add->ms_close();
}
if($_POST['asurf']){
	$site=new mysql;
	$site->connect();
	$site->query_str="select id from asurf where url='".$_POST['asurf_site']."'";
	$site->ms_query();
	if(mysql_num_rows($site->query_result)!=0){
		$id=mysql_fetch_array($site->query_result);
		$asid=$id[0];
	} else {
		$site->query_str="insert into asurf values(NULL,2,'".$_POST['asurf_site']."','0','0',20,'".md5($_POST['pass'])."',now())";
		$site->ms_query();
		$asid=mysql_insert_id();
	}
	$site->ms_close();
	$target['<!--unauth_data-->']="<p>Для просмотра статистики запомните ваши данные:</p><p>id сайта : ".$asid."</p><p>Пароль : ".$_POST['pass']."</p>";

	$target['xxxxx"']=$asid."\"";
}



$target['-SITE_ADDR-']=$session->PATH_HTTP;
//target
require_once("news.class.php");
$new=new blocknews();
$target['<!--news-->']=$new->block("news");


$page=new page;
$context=new contdisplay;
$target['<!--rblock-->']=$context->display(10);
$target['<!--ban_price-->']=$page->ban_price;
$target['<!--title-->']="Автосерфинг";
$target['-@keywords@-']="Автосерфинг";
$target['-@description@-']="Автосерфинг";
$target['-@author@-']="";
$cont=$page->replace_file("index.tpl","menu,menu1,menu2,footer,content#".$aspage,$target);
print $cont;
?>