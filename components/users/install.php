<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installUsers=array("name"=>"Пользователи",
"description"=>"Редактирование пользователей",
"install"=>"",
"tpl_replace"=>array("<!--kvn_script_user-->"=>"<script type='text/javascript' src='<?=\$PATH?>/js/jquery.simplemodal.js'></script>
<script src=\"<?=\$PATH?>/js/contact.js\"></script>","<!--kvn_user-->"=>"<div class=\"topline\" id=\"contact-form\">
<a href=\"#\" class=\"login\"><?=\$GLOBALS['dblang_enter'][\$GLOBALS['userlanguage']]?></a>
<a href=\"#\" class=\"contact\"><?=\$GLOBALS['dblang_register'][\$GLOBALS['userlanguage']]?></a>
</div>","<!--kvn_css_user-->"=>"<link rel=\"stylesheet\" href=\"<?=\$PATH?>/css/contact.css\">
<link rel=\"stylesheet\" href=\"<?=\$PATH?>/css/oneclick.css\">"),
"submenu"=>array(1 => 'Добавление клиента', 2 => 'Меню клиента', 3 => 'Прайс-лист', 4 => 'Настройки', 5 => 'Рассылка', 6 => 'Подписчики',7=>"Настройки регистрации"),
"queries"=>array("INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Участники', 'users', 21, 1)","CREATE TABLE IF NOT EXISTS `".$PREFIX."users` (
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
  `actype` smallint(3) NOT NULL,
  `percent` tinyint(2) unsigned NOT NULL,
  `udata` blob NOT NULL,
  `money` mediumint(10) unsigned NOT NULL,
  `amount` smallint(5) unsigned NOT NULL,
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
  KEY `tmp_pass` (`tmp_pass`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."menu_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `ordering` smallint(6) NOT NULL,
  UNIQUE KEY `id` (`id`)
)")
);
?>