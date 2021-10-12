<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installPayment=array("name"=>"Оплата онлайн",
"description"=>"Оплата товаров онлайн(paypal)",
"install"=>"",
"tpl_replace"=>array(),
"css_replace"=>array(),
"queries"=>array('CREATE TABLE IF NOT EXISTS `'.$PREFIX.'payment` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `userid` int(11) unsigned NOT NULL,
  `package_id` int(11) unsigned NOT NULL,
  `order_date` varchar(32) character set utf8 NOT NULL,
  `price` varchar(32) character set utf8 NOT NULL,
  `pp_payer_id` varchar(64) character set utf8 NOT NULL,
  `pp_payer_status` varchar(32) character set utf8 NOT NULL,
  `pp_payer_email` varchar(256) character set utf8 NOT NULL,
  `pp_txn_id` varchar(64) character set utf8 NOT NULL,
  `pp_payment_date` varchar(64) character set utf8 NOT NULL,
  `pp_payment_status` varchar(64) character set utf8 NOT NULL,
  `pp_pending_reason` varchar(128) character set utf8 NOT NULL,
  `pp_verified` varchar(32) character set utf8 NOT NULL,
  `pay_date` varchar(32) character set utf8 NOT NULL,
  `payment_gross` varchar(32) character set utf8 NOT NULL,
  `mc_gross` varchar(32) character set utf8 NOT NULL,
  `note` varchar(16) character set utf8 NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`),
  KEY `note` (`note`)
)')
);
?>