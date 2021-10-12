<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installBrand_model=array("name"=>"Каталог по брендам и моделям",
"description"=>"Меню по брендам и моделям",
"install"=>"",
"copy"=>array("modules/brand_model/catalog_menu.php"=>"modules/catalog_menu.php"),
"tpl_replace"=>array("<!--kvn_catalog_menu-->"=>"<?php load_module(\"catalog_menu\", 0); ?>"),
"submenu"=>array(1=>'Бренды',2=>'Модели',3=>'Позиции',4=>'Обработка фото',5=>'Описания',6=>'Цены и города',7=>'СПб',8=>'Москва'),
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."cart` (
  `id` bigint(15) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `gruz_id` varchar(64) NOT NULL,
  `amount` int(11) unsigned NOT NULL,
  `action` varchar(4) NOT NULL,
  `add_date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."catalog_brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `altname` text NOT NULL,
  `showmenu` int(11) NOT NULL,
  `position` tinyint(3) unsigned NOT NULL,
  `rusname` varchar(32) DEFAULT '',
  PRIMARY KEY (`id`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."catalog_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oem` text NOT NULL,
  `name` text NOT NULL,
  `brand_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `model_variants` text NOT NULL,
  `oem_variants` text NOT NULL,
  `available` text NOT NULL,
  `price` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `waitingfor` text NOT NULL,
  `special` text NOT NULL,
  `keywords` text NOT NULL,
  `syncdate` text NOT NULL,
  `section` int(11) NOT NULL DEFAULT '0',
  `av` int(11) NOT NULL DEFAULT '0',
  `country` text NOT NULL,
  `provider` varchar(32) NOT NULL DEFAULT '',
  `msk` mediumint(12) unsigned NOT NULL DEFAULT '0',
  `spb` mediumint(12) unsigned NOT NULL DEFAULT '0',
  `nova` varchar(4) NOT NULL DEFAULT '',
  `opt` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."catalog_items2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `linked_item` text NOT NULL,
  `keywords` text NOT NULL,
  `model_id` int(11) NOT NULL,
  `section` int(11) NOT NULL,
  `alt` text NOT NULL,
  PRIMARY KEY (`id`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."catalog_models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `altname` text NOT NULL,
  `image` text NOT NULL,
  `showimg` int(11) NOT NULL,
  `position` smallint(6) NOT NULL,
  `rusname` varchar(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
)","INSERT INTO `".$PREFIX."modules` (`module`, `position`, `ordering`, `admin`,`name`) VALUES('catalog_menu', 'catalog_menu', 4, 0,'catalog_menu')")
);
?>