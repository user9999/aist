<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) die();
$installAdmin_users=array("name"=>"Администраторы",
"description"=>"",
"install"=>"",
"tpl_replace"=>array(),
"css_replace"=>array(),
"index_replace"=>array(),
"submenu"=>array('View'=>'Просмотр','Add'=>'Добавление','Edit'=>'Редактирование',),
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."admin_users` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` varchar(255) NOT NULL,`login` varchar(32) NOT NULL,`password` varchar(64) NOT NULL,`phone`  varchar(32) NOT NULL,`email`  varchar(64) NOT NULL,`data` TEXT NOT NULL,`reg_date` TIMESTAMP NOT NULL,`active` tinyint UNSIGNED NOT NULL)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Администраторы', 'admin_users', 77, 1)"),
);
?>