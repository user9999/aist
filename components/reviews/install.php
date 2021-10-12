<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installReviews=array("name"=>"Отзывы",
"description"=>"Отзывы посетителей",
"install"=>"",
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."reviews` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uname` varchar(128) CHARACTER SET utf8 NOT NULL,
  `umail` varchar(128) CHARACTER SET utf8 NOT NULL,
  `title` varchar(128) CHARACTER SET utf8 NOT NULL,
  `review` text CHARACTER SET utf8 NOT NULL,
  `pubdate` varchar(32) CHARACTER SET utf8 NOT NULL,
  `permittion` tinyint(2) unsigned NOT NULL,
  `ip` varchar(32) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `permittion` (`permittion`)
)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Отзывы', 'reviews', 22, 1)")
);
?>