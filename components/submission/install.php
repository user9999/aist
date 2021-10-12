<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installSubmission=array("name"=>"Подписка на новости",
"description"=>"Подписка на новости",
"install"=>"",
"tpl_replace"=>array("<!--kvn_submission-->"=>""),
"css_replace"=>array("/*more_styles*/"=>""),
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."submission` (
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(32) NOT NULL,
  `unsub` varchar(32) NOT NULL,
  `subdate` int(10) NOT NULL,
  UNIQUE KEY `email` (`email`)
)")
);
?>