<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installMenu=array("name"=>"Меню",
"description"=>"Меню сайта Заменяет &lt;!--kvn_menu_main--&gt; на код меню",
"tpl_replace"=>array("<!--kvn_menu_main-->"=>"<?php load_module(\"[position]\", 0); ?> "),
"install"=>"checked",
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."menu` (
  `id` int(11) NOT NULL auto_increment,
  `text` text NOT NULL,
  `path` text NOT NULL,
  `ordering` int(11) NOT NULL,
  `parent` int(11) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Меню сайта', 'menu', 2, 1)")
);
?>