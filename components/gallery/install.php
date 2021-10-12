<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installGallery=array("name"=>"Галерея",
"description"=>"Галерея",
"install"=>"",
"submenu"=>array(1 => 'Загрузка', 2 => 'Редактирование', 3 => 'Настройки'),
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."gallery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link` varchar(128) NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `position` smallint(3) unsigned NOT NULL,
  `display` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Галерея', 'gallery', 15, 1)")
);
?>