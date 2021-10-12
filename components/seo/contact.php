<?php
header("Content-Type: text/html; charset=windows-1251");
session_start();
require_once("page.class.php");
require_once("contdisplay.php");
require_once("simplecaptcha.class.php");
//require
if($_POST['send']){
	if ($_SESSION['string'] != $_POST['code']){
		$target['<!--warn-->']="<p class=\"warn\">Неправильно введен код с картинки!</p>";
		//die("<p class=\"warn\">Неправильно введен код с картинки!</p>");
	} else {


//Редактировать

	require_once("mysql.class.php");
    	$mes=new mysql;




    	setlocale (LC_ALL,'rus','russian');//ru_RU.cp1251
	if(!preg_match("/^[\w]{3,30}$/is",$_POST['name'])){
	        	$ret.="<p class=\"warn\"> - Имя может содержать от 3-х до 30-ти букв</p>";
	}
	if($_POST['email']=="" || !preg_match("!^([a-z0-9]{1})([a-z0-9\._-]+)@([a-z0-9\.-_]+)\.([a-z0-9]{2,5})$!is",$_POST['email'],$match)){
	        	$ret.="<p class=\"warn\"> - Неправильно введен email</p>";
	}
	if(strlen($_POST['letter'])<12){
		$ret.="<p class=\"warn\"> - Слишком короткое сообщение.</p>";
	}
	if($ret==""){


//Редактировать
		$mes->connect();
		$mes->query_str="insert into ".$mes->db_prefix."mess(name,email,mess,mdate) values('".$_POST['name']."','".$_POST['email']."','".addslashes(strip_tags($_POST['letter']))."','".time()."')";
		//die($mes->query_str);
		$mes->ms_query();
		//$mes->query_str="select email from data";
		//$mes->ms_query();

			
		$mail=$mes->adminmail;

//
		$from=($_POST['email']=="")?"From: mailrobot":"From: ".$_POST['email'];
		$theme="Письмо от ".$_POST['name']." с ".$mes->PATH_HTTP;
		$body=strip_tags($_POST['letter'])."\n\n Контактные данные : ".$_POST['email'];
			
	
		mail($mail,$theme,$body,$from);
		$ret.="<br /> - Сообщение успешно отправлено.";
		//}
		
		
		$mes->ms_close();
			

    $target['<!--warn-->']=$ret;
	
	
	} else {
    //die($ret);
    $target['<!--warn-->']=$ret;
	}
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
$cont=$page->replace_file("index.tpl","menu,menu1,menu2,footer,content#contact",$target);
print $cont;
?>