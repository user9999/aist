<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installAccount=array("name"=>"Аккаунт партнерки",
"description"=>"Партнерская программа продаж - Аккаунт партнера",
"tpl_replace"=>array(),
"install"=>"",
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."menu_partners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `ordering` smallint(6) NOT NULL,
  UNIQUE KEY `id` (`id`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."partner_message` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `sender` mediumint(8) unsigned NOT NULL,
  `title` varchar(256) NOT NULL,
  `message` blob NOT NULL,
  `messageid` mediumint(8) unsigned NOT NULL,
  `recipient` mediumint(8) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `sendtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."partner_money` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `partnerid` mediumint(9) unsigned NOT NULL,
  `order_id` mediumint(9) unsigned NOT NULL,
  `cash` decimal(9,2) NOT NULL,
  `cashsum` decimal(9,2) NOT NULL,
  `ordertime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."partner_rules` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `rule` blob NOT NULL,
  `percent1` decimal(4,2) unsigned NOT NULL,
  `percent2` decimal(4,2) unsigned NOT NULL,
  `minimum` smallint(4) unsigned NOT NULL,
  `withdraw` varchar(255) NOT NULL,
  `email` varchar(126) NOT NULL,
  `client` mediumint(7) unsigned NOT NULL,
  PRIMARY KEY (`id`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."partner_users` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(126) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `activation` varchar(64) NOT NULL,
  `letters` tinyint(2) unsigned NOT NULL,
  `blok` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."partner_withdraw` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `partnerid` mediumint(8) unsigned NOT NULL,
  `cash` decimal(9,2) NOT NULL,
  `paysys` varchar(255) NOT NULL,
  `number` text NOT NULL,
  `confirm` varchar(32) NOT NULL,
  `ordertime` int(10) unsigned NOT NULL,
  `confirmtime` int(10) unsigned NOT NULL,
  `paytime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
)")
);
?>
