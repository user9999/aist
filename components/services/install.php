<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installServices=array("name"=>"Бронь по календарю",
"description"=>"Бронирование услуг, номеров по календарю",
"install"=>"",
"submenu"=>array(1 => 'Управление услугами', 2 => 'Заказы'),
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."lang_text` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `table_name` varchar(64) character set utf8 NOT NULL,
  `rel_id` int(10) unsigned NOT NULL,
  `language` varchar(8) character set utf8 NOT NULL,
  `title` text character set utf8 NOT NULL,
  `short` text character set utf8 NOT NULL,
  `content` text character set utf8 NOT NULL,
  `description` varchar(256) character set utf8 NOT NULL,
  `keywords` text character set utf8 NOT NULL,
  `pub_date` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `table` (`table_name`,`rel_id`),
  KEY `pub_date` (`pub_date`),
  KEY `language` (`language`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."services` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `price` varchar(32) character set utf8 NOT NULL,
  `alias` varchar(128) character set utf8 NOT NULL,
  `position` smallint(4) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `alias` (`alias`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."service_orders` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `phone` text NOT NULL,
  `address` text NOT NULL,
  `email` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL default '0',
  `product_id` int(11) unsigned NOT NULL,
  `day` smallint(2) unsigned NOT NULL,
  `month` tinyint(2) unsigned NOT NULL,
  `year` smallint(4) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `day` (`day`,`month`,`year`)
) ","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Бронь по календарю', 'services', 7, 1)")
);
?>