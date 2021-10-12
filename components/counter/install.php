<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installCounter=array("name"=>"Счетчик",
"description"=>"Счетчик посещений",
"tpl_replace"=>array(),
"index_replace"=>array(""=>""),
"install"=>"",
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."ip_table` (
  `ip_id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_ip` varchar(20) NOT NULL DEFAULT '',
  `ip_deny_access` tinyint(4) NOT NULL DEFAULT '0',
  `ip_no_statistic` tinyint(4) NOT NULL DEFAULT '0',
  `ip_comment` varchar(255) NOT NULL DEFAULT '',
  `users_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ip_id`),
  KEY `ip_ip` (`ip_ip`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."visitors` (
  `id` bigint(16) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `browser` blob NOT NULL,
  `intime` int(10) unsigned NOT NULL,
  `partnerid` int(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."visits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(16) unsigned NOT NULL,
  `page` varchar(256) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `refer` varchar(256) NOT NULL,
  `vtime` int(10) unsigned NOT NULL,
  UNIQUE KEY `id` (`id`)
)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Счетчик', 'counter', 17, 1)")
);
?>
