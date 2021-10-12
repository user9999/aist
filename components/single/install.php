<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installSingle=array("name"=>"Одиночный",
"description"=>"",
"install"=>"",
"tpl_replace"=>array(),
"css_replace"=>array(),
"index_replace"=>array(),
"submenu"=>array('View'=>'Просмотр','Add'=>'Добавление','Edit'=>'Редактирование',),
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."single`(`id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,`script`  text,info text)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Одиночный', 'single', 103, 1)"),
);
?>