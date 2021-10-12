<?php
//ini_set('display_errors', 1);
  //error_reporting(E_ALL);
require_once("session.class.php");
require_once("page.class.php");
require_once("contdisplay.php");

$session=new session;

if(!$session->session_true()){

	$aspage="/unauth_1";
	if($_POST['enter']){
		$session->session_begin($_POST['login'],$_POST['pass']);
	}
	if ($_POST['generate']) {
		require_once("dorfree.class.php");
		$door=new dorfree;
		$res=$door->generate();
		$target['<!--templates-->']=$res;
	}
	$door="dorfree";
$target['<!--enter-->']="<form method=\"post\">Логин<input type=\"text\" name=\"login\">
Пароль<input type=\"password\" name=\"pass\">
<input type=\"submit\" name=\"enter\" value=\"войти\"></form>
<a href=\"register.php\">Регистрация</a><br /><a href=\"remember.php\">Напомнить пароль</a>";
}
if($session->session_true()){
	$door="dorgen";
	if(is_dir("userfiles/".$_SESSION['id'])){
		$target['<!--userfiles-->']="<table><caption>Ваши темплейты</caption>";
		foreach(glob("userfiles/".$_SESSION['id']."/*.tpl") as $file){
			$file=eregi_replace("userfiles/".$_SESSION['id']."/","",$file);
			$target['<!--userfiles-->'].="<tr><td>".substr($file,0,-4)."</td><td><a href=\"#\" onclick=\"javascript:window.open('tplredact.php?tpl=".substr($file,0,-4)."','tpl','');\">редактировать</a></td><td><a href=\"#\" onclick=\"unlink('".substr($file,0,-4)."');\">удалить</a></td><td>использовать <input type=\"radio\" name=\"tpl\" value=\"".substr($file,0,-4)."\" /></td><td><iframe src=\"tplstat.php?file=".substr($file,0,-4)."\" style=\"width:50px;height:18px;border:0;overflow:hidden\" id=\"".substr($file,0,-4)."\"></iframe></td></tr>\r\n";
		}
		$target['<!--userfiles-->'].="<tr><td>default.html</td><td><a href=\"#\" onclick=\"javascript:window.open('tplredact.php?tpl=default','tpl','');\">редактировать</a></td><td></td><td>использовать <input type=\"radio\" name=\"tpl\" value=\"default\" /></td><td>есть</td></tr>\r\n";
		$target['<!--userfiles-->'].="<tr><td>default.php</td><td><a href=\"#\" onclick=\"javascript:window.open('tplredact.php?tpl=defaultphp','tpl','');\">редактировать</a></td><td></td><td>использовать <input type=\"radio\" name=\"tpl\" value=\"defaultphp\" /></td><td>есть</td></tr>\r\n";
		$target['<!--userfiles-->'].="</table>";
	} else {
		$target['<!--userfiles-->']="<br /><a href=\"#\" onclick=\"javascript:window.open('tplredact.php?tpl=default','tpl','');\">редактировать html заготовку</a>";
		$target['<!--userfiles-->'].="<br /><a href=\"#\" onclick=\"javascript:window.open('tplredact.php?tpl=phpdefault','tpl','');\">редактировать php заготовку</a>";
	}
	$target['<!--enter-->']="Аккаунт ".$_SESSION['logged']."<br /><form method=\"post\"><input type=\"submit\" name=\"logout\" value=\"выйти\"></form>";
	if($_POST['logout']){
		unset($_SESSION);
		session_destroy();
		$target['<!--enter-->']="<form method=\"post\">Логин<input type=\"text\" name=\"login\">
		Пароль<input type=\"password\" name=\"pass\">
		<input type=\"submit\" name=\"enter\" value=\"войти\"></form>
		<a href=\"register.php\">Регистрация</a><br /><a href=\"remember.php\">Напомнить пароль</a>";
		$aspage="/unauth_1";
	}
	if ($_POST['generate']) {
		$state=1;
		if($_POST['picture']!=0 || (isset($_FILES['userfile']['name']) && $_POST['picture']!=3) ){
			require_once("upload.class.php");
			$pic=new upload;
			$state=$pic->up();
			if($state!=2){
				$target['<!--templates-->']=$state;
			}
		}
	//print "state=".$state." ".$_FILES['userfile']['name'];
		if($state==1 || $state==2){
			require_once("dorgen.class.php");
			$doorgen=new dorgen;
			$res=$doorgen->generate($state);
			//var_dump($res);
			$target['<!--templates-->']=$res;
		}

	}
}
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
$cont=$page->replace_file("index.tpl","menu,menu1,menu2,footer,content#".$door,$target);
print $cont;
?>