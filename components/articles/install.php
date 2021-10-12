<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installArticles=array("name"=>"Каталогизатор статей",
"description"=>"Дерево статей, параграфы",
"install"=>"",
"submenu"=>array(1=>'Добавление статьи',2=>'Настройки оплаты'),
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."articles` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `date` varchar(64) character set utf8 NOT NULL,
  `parent` int(11) unsigned NOT NULL,
  `level` tinyint(2) unsigned NOT NULL,
  `position` smallint(4) unsigned NOT NULL,
  `ordering` int(8) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `date` (`date`),
  KEY `parent` (`parent`),
  KEY `ordering` (`ordering`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."lang_text` (
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
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."packages` (
  `id` smallint(6) unsigned NOT NULL,
  `period` enum('1','12','','') NOT NULL,
  `price` varchar(64) character set utf8 NOT NULL,
  `access` text character set utf8 NOT NULL,
  UNIQUE KEY `id` (`id`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."payment` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `userid` int(11) unsigned NOT NULL,
  `package_id` int(11) unsigned NOT NULL,
  `order_date` varchar(32) character set utf8 NOT NULL,
  `price` varchar(32) character set utf8 NOT NULL,
  `pp_payer_id` varchar(64) character set utf8 NOT NULL,
  `pp_payer_status` varchar(32) character set utf8 NOT NULL,
  `pp_payer_email` varchar(256) character set utf8 NOT NULL,
  `pp_txn_id` varchar(64) character set utf8 NOT NULL,
  `pp_payment_date` varchar(64) character set utf8 NOT NULL,
  `pp_payment_status` varchar(64) character set utf8 NOT NULL,
  `pp_pending_reason` varchar(128) character set utf8 NOT NULL,
  `pp_verified` varchar(32) character set utf8 NOT NULL,
  `pay_date` varchar(32) character set utf8 NOT NULL,
  `payment_gross` varchar(32) character set utf8 NOT NULL,
  `mc_gross` varchar(32) character set utf8 NOT NULL,
  `note` varchar(16) character set utf8 NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`),
  KEY `note` (`note`)
)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Каталог статей', 'articles', 14, 1)")
);
?>
