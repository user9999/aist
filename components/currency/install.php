<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installCurrency=array("name"=>"Валюта",
"description"=>"Курс валюты",
"install"=>"",
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."currency` (
  `id` tinyint(2) unsigned NOT NULL,
  `euro` text NOT NULL,
  `dollar` text NOT NULL,
  `currency` varchar(6) NOT NULL,
  `freq` mediumint(6) unsigned NOT NULL,
  `ratio` varchar(12) NOT NULL,
  `lasttime` int(10) unsigned NOT NULL,
  UNIQUE KEY `id` (`id`)
)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Валюта', 'currency', 6, 1)")
);
?>