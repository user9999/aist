<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installImageeditor=array("name"=>"Редактор картинок",
"description"=>"SEO Редактор картинок",
"install"=>"",
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."imagealt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` text CHARACTER SET utf8 NOT NULL,
  `alt` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Редактор изображений', 'imageeditor', 12, 1)")
);
?>