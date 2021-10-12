<?php
header("Content-Type: text/html; charset=windows-1251");
require_once("mysql.class.php");
$banner=new mysql;
$banner->connect();
$ban_time=25;
if(!$_POST['id_ban']){
	$banner->query_str="select max(id) from banner";
	$banner->ms_query();
	$random=mysql_fetch_row($banner->query_result);
	$id_ban=mt_rand(0,$random[0]);
} else {
	$id_ban=$_POST['id_ban'];
}
if(isset($_GET['netid']) && is_numeric($_GET['netid'])){
	$net_query="width=".$_GET['netid']." and ";
}
if(isset($_GET['bid']) && is_numeric($_GET['bid'])){
	$qbid=" and id!=".$_GET['bid'];
	$banner->query_str="update banner set amount=amount+0.75 where id=".$_GET['bid'];
	$banner->ms_query();
}
$banner->query_str="select id,url,img,alt,width,height from banner where ".$net_query."amount>0 and id>".$id_ban.$qbid." limit 1";
$banner->ms_query();
if(mysql_num_rows($banner->query_result)){
	$bdata=mysql_fetch_row($banner->query_result);
	$banner->query_str="update banner set amount=amount-1 where id=".$bdata[0];
	$banner->ms_query();
	$banner->query_str="insert into banstat values(NULL,".$bdata[0].",'".$_SERVER['REMOTE_ADDR']."',now())";
	$banner->ms_query();
//////////////
} else {
	$banner->query_str="select id,url,img,alt,width,height from banner where ".$net_query."amount>0 and id>0".$qbid." limit 1";
	$banner->ms_query();
	if(mysql_num_rows($banner->query_result)){
		$bdata=mysql_fetch_row($banner->query_result);
		$banner->query_str="update banner set amount=amount-1 where id=".$bdata[0];
		$banner->ms_query();
		$banner->query_str="insert into banstat values(NULL,".$bdata[0].",'".$_SERVER['REMOTE_ADDR']."',now())";
		$banner->ms_query();
///////////////
	} else {
		$bdata[5]=60;
		$bdata[0]=0;
		$bdata[1]=$banner->default_url;
		$bdata[2]=$banner->default_banner;
		$bdata[3]="Все виды раскрутки сайта";
		$bdata[4]=468;
		$ban_time=600;
	}
}
$banner->ms_close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>
<head>
<title>автосерфинг</title>
<meta http-equiv="Content-Type" content="text/html;charset=windows-1251" />
<meta name="keywords" content="" />
<style type="text/css">
html,body{
	margin:0 0 0 0;
	padding:0 0 0 0;font-size:10pt;
}
</style>
<script type="text/javascript" language="JavaScript">
var begin=1;
var a=<?=$ban_time;?>;
var counter=1+parseInt(a);
var paused=0;
function start_time(){do_count();} 
function do_count(){

	parent.document.getElementById('bannerexchange').style.height=<?=$bdata[5];?>+"px";
	parent.document.getElementById('bannerexchange').style.width=<?=$bdata[4];?>+"px";
	if(paused==0){counter--;}
	if(counter>=0){
		setTimeout("do_count()",1000);
	}
	if(counter<0){
		counter=1+parseInt(a);
		do_count();
		document.banner.submit();
	}
}
function doload(){
}
</script>
</head>
<body onload="do_count()">
<a href="<?=$bdata[1];?>" target="blank" onclick="doload();"><img src="<?=$bdata[2];?>" alt="<?=$bdata[3];?>" width="<?=$bdata[4];?>" height="<?=$bdata[5];?>" border="0" /></a>
<form name="banner" method="post">
<input type="hidden" name="id_ban" value="<?=$bdata[0];?>" />
</form>
</body>
</html>
