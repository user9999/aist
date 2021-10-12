<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>
<head>
<title>автосерфинг</title>
<meta http-equiv="Content-Type" content="text/html;charset=windows-1251" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="author" content="" />
<meta name="copyright" content="" />
<meta name="generator" content="" />
<meta name="reply-to" content="" />
</head>
<?php
if($_GET['asurf_site']){
	require_once("mysql.class.php");
	$addsite=new mysql;
	$addsite->connect();
	$addsite->query_str="select id from asurf where url='".$_GET['asurf_site']."'";
	$addsite->ms_query();
	if(mysql_num_rows($addsite->query_result)){
		$idurl=mysql_fetch_row($addsite->query_result);
		$id=$idurl[0];
		$addsite->query_str="update asurf set lastdate=now() where id=".$id;
		$addsite->ms_query();
	} else {
		$addsite->query_str="insert into asurf values(NULL,2,'".$_GET['asurf_site']."','0','0',20,'".md5($_GET['pass'])."',now())";
		$addsite->ms_query();
		$addsite->query_str="SELECT LAST_INSERT_ID()";
		$addsite->ms_query();
		$idurl=mysql_fetch_row($addsite->query_result);
		$id=$idurl[0];
	}
	$addsite->ms_close();
	$var=$_GET['asurf_site'];
	$fr_var=$_GET['asurf_site'];
}
if($_GET['ref_site']){
	$ref_site=$_GET['ref_site'];
} else {
	$ref_site=0;
}
?>
<frameset rows="100,*">
<frame src="aframe.php?url=<?=$fr_var;?>&id=<?=$id;?>&ref_site=<?=$ref_site;?>" name="aframe" />
<frame src="ago.php?url=<?=$var;?>" name="ago" />
</frameset>
</html>