<?php
session_start();
require_once("parseform.class.php");
require_once("mysql.class.php");
require_once("search.class.php");
$be = new search();
if($_POST){
	$be->addHeaderLine("Accept","text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5" );
	$be->addHeaderLine("Accept-Language","ru-ru,ru;q=0.8,en-us;q=0.5,en;q=0.3" );
	$be->addHeaderLine("Accept-Encoding","gzip,deflate" );//"x-compress; x-zip"); compress;q=0.5, gzip;q=1.0
	$be->addHeaderLine("Accept-Charset","windows-1251,utf-8;q=0.7,*;q=0.7" );
	$be->addHeaderLine("Content-Type", "application/x-www-form-urlencoded");
	$be->debug="true";
	$be->addHeaderLine("Referer",$_GET['url'] );
	foreach($_POST as $key=>$value){
		$be->addPostData($key, $value);
	}
	$file = $be->fopen($_GET['action']);
	if($be->answer=302){
		$re=$be->getLastResponseHeaders();
		foreach($re as $ret){
			preg_match_all("!(Location:)(.+)!is",$ret,$link);
			if($link[2][0]!="") $loc=$link[2][0];     // ссылка moved 
		}
		if(substr_count($loc,"/")<2){
			$site=preg_replace("'([^/]+)$'is","",$_GET['url']);
			$loc=$site.trim($loc);
		}
		header("location:".$loc);
	}
        while ($line = fgets($file , 1024)) { 
    		$content.=$line;
	} 
	fclose($file);
	print $content;
} else {
$site=new mysql;
$site->connect();
$site->query_str="select id,guest from guests where id>90 limit 1";
$site->ms_query();
$url=mysql_fetch_row($site->query_result);
if(is_numeric($url[1])){
	$url="http://www.narod.ru/guestbook/?owner=".$url[1];
}
$site->query_str="select id,name,email,url,content from spam where id>3 limit 1";
$site->ms_query();
$user=mysql_fetch_row($site->query_result);
$site->ms_close();
$be->addHeaderLine("Accept","text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5" );
$be->addHeaderLine("Accept-Language","ru-ru,ru;q=0.8,en-us;q=0.5,en;q=0.3" );
$be->addHeaderLine("Accept-Encoding","gzip,deflate" );//"x-compress; x-zip"); compress;q=0.5, gzip;q=1.0
$be->addHeaderLine("Accept-Charset","windows-1251,utf-8;q=0.7,*;q=0.7" );
$be->addHeaderLine("Content-Type", "application/x-www-form-urlencoded");
//$be->debug="true";
$be->addHeaderLine("Referer",$url );
//$response = $be->getLastResponseHeaders(); 
$handle = $be->fopen($url);
while (!feof($handle)) {
  $cont .= fread($handle, 8192);
}
fclose($handle);

if(substr_count($url,"/")>2){
	$site=preg_replace("'([^/]+)$'is","",$url);
} else {
	$site=$url."/";
}
$cont=preg_replace("#href=['\"]?(?!(http://))(\.)?(/)?([^'^\"^\s]+)['\"\s]?#is","href=".$site."\$4 ",$cont);
$cont=preg_replace("#src=['\"]?(?!(http://))(\.)?(/)?([^'^\"^\s]+)['\"\s]?#is","src=".$site."\$4 ",$cont);
$cont=preg_replace("#action=['\"]?(?!(http://))(\.)?(/)?([^'^\"^\s]+)['\"\s]?#is","action=\"submit.php?url=".$url."&action=$site\$4\" ",$cont);
$cont=preg_replace("#url\(['\"]?(?!(http://))(\.)?(/)?([^'^\"^\s]+)['\"\)]?#is","url(".$site."\$4 ",$cont);
$form=new parseform($cont,$url);
$textarea=$form->textarea();
foreach($textarea['line'] as $text){
	if(stristr($text,"mess")){
			$cont=preg_replace("!(<textarea)(.*?)(>)(.*?)(</textarea>)!is","$1$2$3".iconv("utf-8","windows-1251",$user[4])."$5",$cont);
	}
}
//$replacement;
$pattern=Array('mail'=>$user[2],'name'=>$user[1],'login'=>$user[1],'nick'=>$user[1],'url'=>$user[3],'site'=>$user[3]);
$inputs=$form->inputs();
$a=0;
foreach($inputs['names'] as $input){
	$stat=0;
	foreach($pattern as $key=>$value){
		if(stristr($input,$key) && $stat==0){
			$newline=preg_replace('!((value=)([\"\']?)([^\'\"^\s^>]+)([\"\'\s]?)){0,1}$!is'," value=\"".$value."\" ",$inputs['line'][$a]);
			$cont=eregi_replace($inputs['line'][$a],$newline,$cont);
			$stat=1;
		}
	}
	$a++;
}
print $cont;
}
?>