<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) die();
$installGeo=array("name"=>"Геолокация",
"description"=>"Определение координат посетителя сайта",
"install"=>"",
"submenu"=>array(1 => 'Настройка', 2 => 'Города'),
"queries"=>array("INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Геолокация', 'geo', 23, 1)")
);
?>