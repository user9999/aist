<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) die();
$installTest=array("name"=>"test",
"description"=>"",
"install"=>"",
"tpl_replace"=>array(),
"css_replace"=>array(),
"index_replace"=>array(),
"submenu"=>array('View'=>'Просмотр','Add'=>'Добавление','Edit'=>'Редактирование',),
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."test` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,`mail` varchar(64) NOT NULL,`alias` varchar(32) NOT NULL,`name` varchar(32) NOT NULL)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('test', 'test', 76, 1)"),
);
?>