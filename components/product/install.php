<?php
if (!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) {
    die();
}
$installProduct=array("name"=>"Каталог продуктов",
"description"=>"",
"install"=>"",
"tpl_replace"=>array(),
"css_replace"=>array(),
"index_replace"=>array(),
"submenu"=>array('View'=>'Просмотр','Add'=>'Добавление','Edit'=>'Редактирование',1 => 'Изменить',2 => '',),
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."product` (`id` int(11) UNSIGNED NOT NULL,`pid` int(11) NOT NULL,`name` varchar(255) NOT NULL,`alias` varchar(128) NOT NULL,`text` text NOT NULL,`images` text NOT NULL,`price` int(11) NOT NULL)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Изделия', 'product', 52, 1)"),
);
