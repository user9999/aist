<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installPreorder=array("name"=>"Предварительные заказы",
"description"=>"Предварительные заказы",
"install"=>"",
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."preorder` (
  `id` bigint(15) unsigned NOT NULL AUTO_INCREMENT,
  `gruz_id` varchar(128) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `amount` smallint(8) unsigned NOT NULL,
  `preorder_date` int(10) NOT NULL,
  `notify` tinyint(1) NOT NULL,
  `order_date` int(10) NOT NULL,
  `perform_date` int(10) NOT NULL,
  `storage` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Пред. заказы', 'preorder', 14, 1)")
);
?>