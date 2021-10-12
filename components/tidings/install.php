<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) die();
$installTidings=array("name"=>"Новости с галереей",
"description"=>"НОвости с галереей",
"install"=>"",
"tpl_replace"=>array(),
"css_replace"=>array(),
"index_replace"=>array(),
"submenu"=>array('View'=>'Просмотр','Add'=>'Добавление','Edit'=>'Редактирование',),
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."tidings` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,`title` varchar(255) NOT NULL,`images` text NOT NULL,`create_time` int(11)  UNSIGNED NOT NULL,`pub_time` int(11)  UNSIGNED NOT NULL,`edit_time` int(11)  UNSIGNED NOT NULL)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Новости с галереей', 'tidings', 57, 1)"),
);
?>