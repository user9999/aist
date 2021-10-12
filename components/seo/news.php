<?php
require_once("page.class.php");
require_once("contdisplay.php");
//require
$page=new page;
if(!isset($_GET['nid']) && !isset($_GET['month']) && !isset($_GET['year'])){
	require_once('mysql.class.php');
	$news=new mysql;
	$news->connect();
	$news->query_str="select * from news order by id DESC limit 20";
	$news->ms_query();
	while($ten=mysql_fetch_row($news->query_result)){
		$target['<!--cnews-->'].="<tr class=\"col\"><td><b><a href=\"news.php?nid=".$ten[0]."\">".stripslashes($ten[2])."</a></b></td></tr><tr><td><p><b>".$ten[1]."</b><br /> - ".stripslashes($ten[3])."...</p><p class=\"read\"><a href=\"news.php?nid=".$ten[0]."\">Читать полностью &gt;&gt;&gt;</a></p></td></tr>";
		
	}

	$news->query_str="select id,year(ndate),month(ndate) from news order by ndate DESC";
	$news->ms_query();
	while($ten=mysql_fetch_row($news->query_result)){
		$line=($cur_year!=$ten[1])?"<br /><a class=\"yearnews\"href=\"news.php?year=".$ten[1]."\">$ten[1]</a><br />\n":"";

		$month=($cur_month!=$ten[2] || ($cur_month==$ten[2] && $cur_year!=$ten[1]))?"| <a href=\"news.php?year=".$ten[1]."&month=".$ten[2]."\">$ten[2]</a>\n":"";
		$target['<!--allnews-->'].=$line.$month;
		$cur_month=$ten[2];
		$cur_year=$ten[1];
	}

	$news->ms_close();
	$target['<!--ptitle-->']="Новости";
	$target['<!--sub-->']="(последние 20 новостей)";
}
if($_GET['nid']>0 && $_GET['nid']<65000){
	require_once('mysql.class.php');
	$news=new mysql;
	$news->connect();
	$news->query_str="select ndate,title from news where id=".$_GET['nid'];
	$news->ms_query();
	if($pt=mysql_fetch_row($news->query_result)){
		$target['<!--ptitle-->']=stripslashes($pt[1]);
		$cont=file($news->path."info/".$_GET['nid'].".txt");
		$target['<!--cnews-->']="<p>".stripslashes(implode("</p><p>",$cont))."</p>";
		$target['<!--sub-->']="(".$pt[0].")";
	} else {
		$cont="( Зайдите в раздел новостей и выберите новость )";
		$target['<!--cnews-->']="<p>".$cont."</p>";
		$target['<!--sub-->']="Такой новости не существует, либо она была удалена!";
	}
	$news->ms_close();
	$target['<!--allnews-->']="<a href=\"news.php\">к новостям</a>";

}else if(is_numeric($_GET['year']) && $_GET['year']>2004){
	require_once('mysql.class.php');
	$news=new mysql;
	$news->connect();
	if($_GET['month']>0 && $_GET['month']<=12){
		
		$news->query_str="select * from news where month(ndate)='".$_GET['month']."' and year(ndate)='".$_GET['year']."' order by id DESC";
		$news->ms_query();
		while($ten=mysql_fetch_row($news->query_result)){
			$target['<!--news-->'].="<tr class=\"col\"><td><b><a href=\"news.php?nid=".$ten[0]."\">".stripslashes($ten[2])."</a></b></td></tr><tr><td><p><b>".$ten[1]."</b><br /> - ".stripslashes($ten[3])."...</p><p class=\"read\"><a href=\"news.php?nid=".$ten[0]."\">Читать полностью &gt;&gt;&gt;</a></p></td></tr>";
		
		}
		$news->ms_close();
		$target['<!--allnews-->']="<a href=\"news.php\">к новостям</a>";
	} else {
		$news->query_str="select id,title,month(ndate),ndate from news where year(ndate)='".$_GET['year']."' order by ndate desc";
		$news->ms_query();
		while($ten=mysql_fetch_row($news->query_result)){
			$month=($cur_month!=$ten[2])?"<tr class=\"month\"><td>".$ten[2]." </td></tr>":"";
			$target['<!--news-->'].=$month;
			$cur_month=$ten[1];
			$target['<!--news-->'].="<tr class=\"col\"><td><b>".$ten[3]." <a href=\"news.php?nid=".$ten[0]."\">".stripslashes($ten[1])."</a></b></td></tr>";
		
		}
		$target['<!--ptitle-->']=$_GET['year'];
		$target['<!--allnews-->']="<a href=\"news.php\">к новостям</a>";
	}
}
//target
require_once("news.class.php");
$new=new blocknews();
$context=new contdisplay;
$target['<!--rblock-->']=$context->display(10);
$target['<!--ban_price-->']=$page->ban_price;
$target['<!--news-->']=$new->block("news");
$target['<!--title-->']="Новости сервиса";
$target['-@keywords@-']="";
$target['-@description@-']="";
$target['-@author@-']="Vlad";
$cont=$page->replace_file("index.tpl","menu,menu1,menu2,footer,content#news",$target);
print $cont;
?>