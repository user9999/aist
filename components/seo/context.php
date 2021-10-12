<?php
header("Content-Type: text/html; charset=windows-1251");
require_once("page.class.php");
require_once("contdisplay.php");
//require
if($_POST['addcont'] || $_POST['contexchange']){
	$amountclick=(iS_numeric($_POST['amountclick']) && $_POST['amountclick']>0)?$_POST['amountclick']:0;
	$amountshow=(iS_numeric($_POST['amountshow']) && $_POST['amountshow']>0)?$_POST['amountshow']:0;
	if(isset($_POST['contexchange'])){
		$pay=1;
		$amountclick=0;
		$amountshow=0;
		$price=0;
	} else {
		$price=$_POST['price'];
		$pay=0;
	}
	require_once("mysql.class.php");
	$add=new mysql;
	$add->connect();
	$add->query_str="insert into context values(NULL,2,'".addslashes($_POST['url'])."','".addslashes($_POST['context'])."','".$price."','".$amountclick."','".$amountshow."','".$pay."','".md5($_POST['pass'])."',now())";
	$add->ms_query();
	$uid=mysql_insert_id();
	$add->ms_close();
	$target['<!--cod-->']="<script src=\"".$add->PATH_HTTP."cpartner.php?sid=".$uid."\"></script>";
	$target['<!--warn-->']="<p class=\"warn\">Запишите ваши данные для просмотра статистики:</p><p class=\"warn\"> id ссылки - ".$uid.";</p><p class=\"warn\"> ваш пароль - ".$_POST['pass'];
}
switch($_GET['act']){
		case "rules":
			$aspage="contrules";
			break;
		case "ord":
			$aspage="contorder";
			break;
		case "stat":
			$aspage="contstat";
			break;
		case "exchange":
			$aspage="contexchange";
			break;
		case "links":
			$aspage="links";
			$context=new contdisplay;
			$target['<!--links-->']=$context->display();

			break;
		default:
			$aspage="contrules";
			break;

}
if($_POST['statistics']){
	require_once("mysql.class.php");
	$add=new mysql;
	$add->connect();
	$add->query_str="select id,url,context,price,click,numshow,pass from context where id=".$_POST['id'];
	$add->ms_query();
	$passw=mysql_fetch_row($add->query_result);
	if(md5($_POST['pass'])===$passw[6]){
		$add->query_str="select click,ip,referer,date(visitdate),time(visitdate) from contextstat where id_context=".$_POST['id'];
		$add->ms_query();
		$amount=mysql_num_rows($add->query_result);
		$target['<!--stat-->']="<table class=\"banstat\"><caption style=\"margin:auto;\"><b>Ваша ссылка</b></caption><tr><td colspan=\"5\"><a href=\"".$passw[1]."\" target=\"_blank\">".stripslashes($passw[2])."</a><br />Цена клика - ".$passw[3]." цента<br />Осталось кликов - ".$passw[4]."<br />Осталось переходов - ".$passw[5]."</td></tr>\n<tr><td>ip-адрес</td><td>referer</td><td>Дата</td><td>Время</td><td>Переход</td></tr>\n";
		while($stat=mysql_fetch_row($add->query_result)){
			if($stat[0]==1){
				$class=" class=\"marked\"";
				$disp="<b>+</b>";
				$num+=1;
			} else {
				$class="";
				$disp="";
			}
			$target['<!--stat-->'].="<tr".$class."><td>".$stat[1]."</td><td>".$stat[2]."</td><td>".$stat[3]."</td><td>".$stat[4]."</td><td>".$disp."</td></tr>\n";
		}
		$ctr=round((100/$amount*$num),2);
		$target['<!--ctr-->']=($ctr==0)?"":"<h3 style=\"text-align:center\" class=\"warn\">Средний CTR - ".$ctr."%</h3>";
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
$target['<!--title-->']="Контекстная реклама";
$target['-@keywords@-']="Контекстная реклама, баннеры, система обмена визитами";
$target['-@description@-']="баннерная реклама";
$target['-@author@-']="";
$cont=$page->replace_file("index.tpl","menu,menu1,menu2,footer,content#".$aspage,$target);
print $cont;
?>