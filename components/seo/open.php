<?php
if(is_numeric($_GET['id'])){
	require_once("mysql.class.php");
	$open=new mysql;
	$open->connect();
	$open->query_str="update context set click=click-1 where id=".$_GET['id'];
	$open->ms_query();
	$open->query_str="select url from context where id=".$_GET['id'];;
	$open->ms_query();
	$url=mysql_fetch_row($open->query_result);
	$open->ms_close();
	header("Location:".$url[0]);
}
?>