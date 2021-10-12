<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) die();
$installForms=array("name"=>"Формы",
"description"=>"",
"install"=>"",
"tpl_replace"=>array(),
"css_replace"=>array(),
"index_replace"=>array(),
"submenu"=>array('View'=>'Просмотр','Add'=>'Добавление','Edit'=>'Редактирование',),
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."forms` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` varchar(255) NOT NULL,`table` varchar(128) NOT NULL,`alias` varchar(128) NOT NULL,`type` varchar(128) NOT NULL,`method` varchar(128) NOT NULL,`action` varchar(32) NOT NULL,`attributes` varchar(255) NOT NULL)","CREATE TABLE IF NOT EXISTS `".$PREFIX."form_inputs` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,`form_id` int(11) unsigned NOT NULL,`text` varchar(255) NOT NULL,`type` varchar(32) NOT NULL,`name` varchar(64) NOT NULL,`attributes` varchar(255) NOT NULL,`placeholder` varchar(255) NOT NULL,`value` varchar(64) NOT NULL,`required` varchar(32) NOT NULL,`check_function` varchar(64) NOT NULL,`make_function` varchar(64) NOT NULL)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Формы', 'forms', 60, 1)"),
);
?>