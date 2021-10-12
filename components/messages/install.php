<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) die();
$installMessages=array("name"=>"Сообщения",
"description"=>"Сообщения от посетителей с сайта",
"install"=>"",
"tpl_replace"=>array(),
"css_replace"=>array(),
"index_replace"=>array(),
"submenu"=>array('View'=>'Просмотр','Edit'=>'Редактирование',),
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."messages` (`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` varchar(255) NOT NULL,`phone` varchar(32) NOT NULL,`email` varchar(128) NOT NULL,`theme` varchar(128) NOT NULL,`message` text NOT NULL,`file` varchar(255) NOT NULL,`type` varchar(32) NOT NULL,`from_url` varchar(255) NOT NULL,`status` tinyont(2) UNSIGNED NOT NULL, `date` varchar(32) NOT NULL)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Сообщения', 'messages', 136, 1)"),
);
?>