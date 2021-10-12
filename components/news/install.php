<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installNews=array("name"=>"Новости",
"description"=>"Лента новостей",
"install"=>"",
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `short_text` varchar(255) NOT NULL,
  `full_text` text NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `images` text NOT NULL,
  PRIMARY KEY (`id`)
)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Новости', 'news', 14, 1)")
);
?>