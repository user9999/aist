<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installOrder=array("name"=>"Заказы",
"description"=>"Заказы товаров в админке",
"install"=>"",
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."orders` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `phone` text NOT NULL,
  `address` text NOT NULL,
  `email` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL default '0',
  `product_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `phone` text NOT NULL,
  `address` text NOT NULL,
  `email` text NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `state` int(11) NOT NULL,
  `utype` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `user_id` varchar(255) NOT NULL DEFAULT '0',
  `delivery` varchar(32) NOT NULL DEFAULT '',
  `currency` varchar(8) NOT NULL DEFAULT '',
  `exrate` varchar(16) NOT NULL DEFAULT '',
  `ratio` varchar(8) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Заказы', 'order', 8, 1)")
);
?>