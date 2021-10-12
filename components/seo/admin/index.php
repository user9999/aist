<?php
require_once("page.class.php");
//require
$page=new page;
//target
$target['<!--title-->']="Главная";
$target['-@keywords@-']="";
$target['-@description@-']="";
$target['-@author@-']="";
$cont=$page->replace_file("admin/index.tpl","admin/menu,content#admin/index",$target);
print $cont;
?>