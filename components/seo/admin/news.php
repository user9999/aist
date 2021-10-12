<?php
require_once("page.class.php");
//require
$page=new page;
$target['<!--atitle-->']="Редактирование новостей";
/////////////////////////////
require_once('mysql.class.php');
if($_POST['news']){
        	unset($_GET['nid']);
        	unset($_GET['a']);
}
if($_GET['nid']>0 && $_GET['nid']<65000){
		if($_GET['a']=="del"){
			$news=new mysql;
			$news->connect();
			$news->query_str="delete from news where id=".$_GET['nid'];
			$news->ms_query();
			$news->ms_close();
			unlink($news->path_news.$_GET['nid'].".txt");
			$target['<!--full-->']="";
			$target['<!--brief-->']="";
		} else {
			$news=new mysql;
			$news->connect();
			$news->query_str="select * from news where id=".$_GET['nid'];
			$news->ms_query();
			$redact=mysql_fetch_row($news->query_result);
			$news->ms_close();
			$body=file($news->path_news.$redact[0].".txt");
		
			$target['<!--brief-->']=stripslashes($redact[3]);
			$target['<!--full-->']=stripslashes(implode("",$body));
			$target['--ntitle--']="value=\"".stripslashes($redact[2])."\"";
			$target['--value--']="value=\"".$redact[0]."\"";
		}
} else {
		$target['<!--full-->']="";
		$target['<!--brief-->']="";
}
$news=new mysql;
$news->connect();
	
$news->query_str="select id,title from ph_themes";
$news->ms_query();
while($theme=mysql_fetch_row($news->query_result)){
		$target['<!--sel_theme-->'].="<option value=\"".$theme[0]."\">".substr($theme[1], 0, 25) ."</option>";
}
	
if($_POST['news']){
		if($_POST['title']!="" && $_POST['brief']!="" && $_POST['full']!=""){
			if($_POST['id']>0 && $_POST['id']<65000){
				$news->query_str="update news set title='".addslashes($_POST['title'])."',brief='".addslashes($_POST['brief'])."' where id=".$_POST['id'];
				$news->ms_query();
				$fp=fopen($news->path_news.$_POST['id'].".txt","w");
        			fwrite($fp,$_POST['full']);
        			fclose($fp);
			} else {
				$news->query_str="insert into news(ndate,title,brief) values(now(),'".addslashes($_POST['title'])."','".addslashes($_POST['brief'])."')";
				$news->ms_query();
				$nid=mysql_insert_id();
		
				$fp=fopen($news->path_news.$nid.".txt","a");
        			fwrite($fp,$_POST['full']);
        			fclose($fp);
			}
		} else {
			$target['<!--warn-->']=$news->mess_begin."Необходимо заполнить все поля!".$news->mess_end;
		}
}
$news->query_str="select id,ndate,title from news";
$news->ms_query();
while($all=mysql_fetch_row($news->query_result)){
	        $target['<!--all-->'].="<tr><td>".$all[1]."</td><td><a href=\"../news.php?nid=".$all[0]."\" target=\"_blank\">".$all[2]."</a></td><td><a href=\"news.php?page=news&nid=".$all[0]."\" class=\"me\">редактировать</a><br /><a href=\"news.php?page=news&nid=".$all[0]."&a=del\" class=\"del\">удалить</a></td></tr>\n";
}
$news->ms_close();
//target
$target['<!--title-->']="Goodjob";
$target['-@keywords@-']="";
$target['-@description@-']="";
$target['-@author@-']="Vlad";	
$cont=$page->replace_file("admin/index.tpl","admin/menu,content#admin/news",$target);
print $cont;
?>