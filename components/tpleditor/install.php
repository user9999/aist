<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installTpleditor=array("name"=>"Редактор шаблонов",
"description"=>"Редактор шаблонов",
"install"=>"",
"queries"=>array("INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Редактор шаблонов', 'tpleditor', 19, 1)")
);
?>