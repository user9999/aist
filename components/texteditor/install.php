<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installTexteditor=array("name"=>"Редактор текстов",
"description"=>"Редактор текстов",
"install"=>"checked",
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."texts` (
  `id` int(11) NOT NULL auto_increment,
  `path` text NOT NULL,
  `text` text NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `meta` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Редактор текстов', 'texteditor', 13, 1)")
);
?>