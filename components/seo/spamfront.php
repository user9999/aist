<?php
if($_POST['enter']){
		$session->session_begin($_POST['login'],$_POST['pass']);
	}
if($_POST['addspam']){
	$add=new mysql;
	$add->connect();
	$add->query_str="insert into spam values(NULL,2,'".addslashes($_POST['name'])."','".addslashes($_POST['email'])."','".addslashes($_POST['url'])."','".addslashes($_POST['content'])."','".$_POST['amount']."','1','".md5($_POST['pass'])."',now(),'0')";
	$add->ms_query();
	$uid=mysql_insert_id();
	$add->ms_close();
	$target['<!--cod-->']="<script src=\"".$add->PATH_HTTP."cpartner.php?sid=".$uid."\"></script>";
	$target['<!--warn-->']="<p class=\"warn\">Запишите ваши данные для просмотра статистики:</p><p class=\"warn\"> id рассылки - ".$uid.";</p><p class=\"warn\"> ваш пароль - ".$_POST['pass'];
}
switch($_GET['act']){
		case "rules":
			$aspage="spamrules";
			break;
		case "ord":
			$aspage="spamorder";
			break;
		case "stat":
			$aspage="spamstat";
			break;
		case "free":
			$aspage="spamfree";
			break;
		default:
			$aspage="spamrules";
			break;
}
if($_POST['statistics']){
	//require_once("mysql.class.php");
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
$enter="fenter";
?>