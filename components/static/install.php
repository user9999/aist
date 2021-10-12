<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installStatic=array("name"=>"Статичные страницы",
"description"=>"Создание статичных страниц",
"install"=>"checked",
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."static` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` text NOT NULL,
  `title` text NOT NULL,
  `text` text NOT NULL,
  `keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  PRIMARY KEY (`id`)
)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Статичные страницы', 'static', 3, 1)")
);
?>