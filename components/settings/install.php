<?php
if (!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) {
    die();
}
$installSettings=array("name"=>"Данные компании",
"description"=>"Настройки телефонов и выводы отдельных полей функцией get_settings('имя поля', array \$settings=null) - \$settings - массив необходимых значений(по умолчанию выводится первое поле (value1))",
"install"=>"",
"tpl_replace"=>array(),
"css_replace"=>array(),
"index_replace"=>array(),
"submenu"=>array('View'=>'Просмотр','Add'=>'Добавление','Edit'=>'Редактирование',),
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."settings` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,alias varchar(64) NOT NULL,value1 varchar(255) NOT NULL,value2 varchar(255) NOT NULL,value3 varchar(255) NOT NULL)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Данные компании', 'settings', 56, 1)"),
);
