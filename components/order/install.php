<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) die();
$installOrder=array("name"=>"Заказы",
"description"=>"",
"install"=>"",
"tpl_replace"=>array(),
"css_replace"=>array(),
"index_replace"=>array(),
"submenu"=>array('View'=>'Просмотр','Add'=>'Добавление','Edit'=>'Редактирование',),
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."order` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` text NOT NULL,`phone` varchar(64) NOT NULL,`address` text NOT NULL,`email` varchar(128)  NOT NULL,`user_id` int(11) unsigned NOT NULL default '0',`delivery` varchar(64)  NOT NULL,`mounting` varchar(64)  NOT NULL,`date` int(10) unsigned NOT NULL,`status` smallint(4) UNSIGNED NOT NULL,`change_date` int(10) unsigned NOT NULL,`total_price` varchar(64)  NOT NULL)","CREATE TABLE IF NOT EXISTS `".$PREFIX."order_units` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,`order_id` int(11) UNSIGNED NOT NULL,`product_id` int(11) UNSIGNED NOT NULL,`parameters` text NOT NULL,`amount` smallint(4) UNSIGNED NOT NULL,`price` varchar(64)  NOT NULL)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Заказы', 'order', 114, 1)"),
);
?>