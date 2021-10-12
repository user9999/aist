<?php
set_time_limit(0);
require_once("session.class.php");
require_once("page.class.php");
require_once("contdisplay.php");

$session=new session;
$target['<!--keys-->']="руками,самодел,ремонт,схема,отзывы,Статистика,видео,цены,цена,фото,стоимость,форум,расценки,порно,скачать";
if(!$session->session_true()){
$yadir='yadir';
if($_POST['sub']){
	$clkeys=Array();$keystr="";
	$target['<!--keys-->']=$_POST['stop'];
	$keys=explode("\n",$_POST['ya']);
	
	$stop="";
	if($_POST['stop']){
		$stop=str_replace(" ","",$_POST['stop']);
		$stop=str_replace(",","|",$stop);
	}
	$cnt=0;$cc=array();
	foreach($keys as $key){
		$clean=preg_replace("![\d]+$!is","",trim($key));
		$clean=preg_replace("!\+!is","",$clean);
		if(strlen($stop)>2 && !in_array(trim($clean),$cc)){
			if(!preg_match("!".$stop."!is",$clean,$match)){
				$cnt++;
				$cc[]=trim($clean);
				$ok.=trim($clean)."\r\n";
				$clkeys[]=trim($clean);
			}
		} elseif(!in_array(trim($clean),$cc)){
			$cnt++;
			$ok.=trim($clean)."\r\n";
		}
	}
	$out="<textarea rows=\"10\" cols=\"60\">".$ok."</textarea>";
	$out.="<br> всего - ".$cnt."<br>";
	$target['<!--keyresult-->']=$out;
}
}
if($session->session_true()){
$yadir='yadirfull';

}
if($_POST['rand']){
	$keys=explode("\n",$_POST['r']);
	shuffle($keys);
	foreach($keys as $key){
		if(strlen(trim($key))>0) $ok.=trim($key)."\r\n";
	}
$keys=$ok;
}
if($_POST['str']==1){
$str=implode(", ",$clkeys);
$len=($_POST['len'])?$_POST['len']:512;
$str1=substr($str,0, $len);
$str2=substr($str,$len);
$target['<!--keystr-->']="<span class=lenok>".$str1."</span><span class=lenmore>".$str2."</span>";

//$keystr
}
//var_dump($_POST['str']);echo "<br>";
//var_dump($target['<!--keystr-->']);
?>



<?php
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

$cont=$page->replace_file("index.tpl","menu,menu1,menu2,footer,content#".$yadir,$target);
print $cont;
?>