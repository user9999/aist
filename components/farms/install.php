<?php
if (!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) {
    die();
}
$installFarms=array("name"=>"Страницы описаний с галереей",
"description"=>"Страницы описаний с галереей",
"install"=>"",
"submenu"=>array(1 => 'Статьи-галереи', 2 => 'Обработка фото', 3 => 'Загрузка фото'),
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."farms` (
  `id` varchar(6) CHARACTER SET utf8 NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `position` tinyint(3) unsigned NOT NULL,
  `display` tinyint(1) unsigned NOT NULL,
  UNIQUE KEY `id` (`id`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."farms_foto` (
  `id` varchar(12) CHARACTER SET utf8 NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `alt` varchar(255) CHARACTER SET utf8 NOT NULL,
  UNIQUE KEY `id` (`id`)
)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Статьи с галереей', 'farms', 18, 1)")
);
