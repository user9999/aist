<?php
require_once ('JsHttpRequest.class.php');
$JsHttpRequest =& new JsHttpRequest("windows-1251");
require_once('mysql.class.php');
$thems=new mysql;
$thems->connect();
$thems->query_str="select name from photo where id_theme=".$_REQUEST['q']." order by ph_date desc";
$thems->ms_query();
$i=0;
while($cho=mysql_fetch_row($thems->query_result)){
	$_RESULT[$i]=$cho[0];
	$i++;
}
$thems->ms_close();
?>