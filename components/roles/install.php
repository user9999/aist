<?php
if (!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) {
    die();
}
$installRoles=array("name"=>"Роли",
"description"=>"Роли администраторов",
"install"=>"",
"tpl_replace"=>array(),
"css_replace"=>array(),
"index_replace"=>array(),
"submenu"=>array('View'=>'Просмотр','Add'=>'Добавление','Edit'=>'Редактирование',),
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."roles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  `roles` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`)
)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Роли', 'roles', 72, 1)"),
);
