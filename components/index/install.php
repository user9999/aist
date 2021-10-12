<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installIndex=array("name"=>"Главная страница",
"description"=>"Главная страница",
"install"=>"checked-readonly",
"submenu"=>array(1 => 'Баннер', 2 => 'Вывод ссылок на 1 страницу', 3 => 'Настройки',4=>"Языки"),
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."frontpage` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `position` smallint(4) NOT NULL,
  `display` tinyint(1) unsigned NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text NOT NULL,
  `type` varchar(12) NOT NULL,
  `section` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `section` (`section`),
  KEY `position` (`position`)
)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Главная', 'index', 1, 1)","INSERT INTO `".$PREFIX."frontpage` (`name`, `title`, `position`, `display`, `url`, `description`, `type`) VALUES
('1457819005.png', '', 3, 1, '', '', 'image')")
);
?>