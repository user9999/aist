<?php
require_once "../inc/configuration.php";
require_once "../inc/functions.php";
//$id = intval($_GET['id']);//$id =2;
$id = explode("&", $_SERVER['QUERY_STRING']);
$id=explode("=", $id[0]);
$id=intval($id[1]);
$node = array();
$userlanguage=userlang();
//$query="select a.id,b.title from ".$PREFIX."articles as a, ".$PREFIX."lang_text as b where a.parent=$id and a.id=b.rel_id and b.table_name='articles' and b.language='$userlanguage'";
$res=mysql_query("select a.id,b.title from ".$PREFIX."articles as a, ".$PREFIX."lang_text as b where a.parent=$id and a.id=b.rel_id and b.table_name='articles' and b.language='$userlanguage'");
while($row=mysql_fetch_row($res)){
    $node[] = "{ \"id\": \"".intval($row[0])."\", \"title\": \"<a href='/articles/".$row[0]."'>".$row[1]."</a>\", \"isFolder\": 1}";
}
echo '['.implode(',', $node).']';
