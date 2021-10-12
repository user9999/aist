<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installReserve=array("name"=>"Бронь",
"description"=>"Бронирование товара",
"install"=>"",
"submenu"=>array(1 => 'Бронь', 2 => 'История', 3 => 'Отказы', 4 => 'Админ'),
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."reserved` (
  `id` bigint(15) unsigned NOT NULL AUTO_INCREMENT,
  `gruz_id` varchar(128) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `amount` smallint(8) unsigned NOT NULL,
  `add_date` int(10) NOT NULL,
  PRIMARY KEY (`id`)
)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Бронь', 'reserve', 19, 1)")
);
?>