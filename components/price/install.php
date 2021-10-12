<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installPrice=array("name"=>"Прайс лист",
"description"=>"Позиции каталога и заливка прайс листа",
"install"=>"",
"submenu"=>array(1=>'Управление позициями',2=>'Импорт товаров', 3=>'Экспорт csv', 4 => 'Цены и города', 5 => 'СПб', 6 => 'Москва'),
"queries"=>array("INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Прайс-лист', 'price', 5, 1)")
);
?>