<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installModuletext=array("name"=>"Тексты модулей",
"description"=>"Тексты для модулей в любом месте страницы (вызов функцией get_moduletext(\$position))",
"install"=>"",
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."module_text` (
  `id` int(11) NOT NULL auto_increment,
  `path` text NOT NULL,
  `text` text NOT NULL,
  `position` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Тексты модулей', 'moduletext', 15, 1)")
);
?>