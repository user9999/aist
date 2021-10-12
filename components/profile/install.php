<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installProfile=array("name"=>"профиль пользователя",
"description"=>"",
"install"=>"",
"queries"=>array(
"CREATE TABLE IF NOT EXISTS `".$PREFIX."users` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `nick` varchar(128) NOT NULL,
  `parent_id` bigint(10) unsigned NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(64) NOT NULL,
  `name` text NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `birthdate` varchar(64) NOT NULL,
  `country` varchar(128) NOT NULL,
  `firm` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(128) NOT NULL,
  `level` tinyint(2) unsigned NOT NULL,
  `ref_amount` tinyint(2) unsigned NOT NULL,
  `points` bigint(10) NOT NULL,
  `regdate` int(10) unsigned NOT NULL,
  `ref2_amount` smallint(3) unsigned NOT NULL,
  `ref3_amount` smallint(4) unsigned NOT NULL,
  `ref4_amount` smallint(5) unsigned NOT NULL,
  `getref` tinyint(1) unsigned NOT NULL,
  `systemref` smallint(3) unsigned NOT NULL,
  `tmp_pass` varchar(64) NOT NULL,
  `package` smallint(5) unsigned NOT NULL,
  `payed_till` int(10) unsigned NOT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`),
  KEY `parent_id` (`parent_id`),
  KEY `password` (`password`),
  KEY `getref` (`getref`),
  KEY `systemref` (`systemref`),
  KEY `tmp_pass` (`tmp_pass`)"
)
);
?>
