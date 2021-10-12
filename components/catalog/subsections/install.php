<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installSubsections=array("name"=>"Каталог по брендам и моделям",
"description"=>"Меню по брендам и моделям",
"install"=>"",
"copy"=>array("modules/subsections/catalog_menu.php"=>"modules/catalog_menu.php"),
"css_replace"=>array("/*automatic catalog menu*/"=>"
#nav{
font-weight:bold;
margin: 0;
padding: 40px 0 0 0;
list-style: none;
height: 468px;
width: 200px;
}
#nav ul {
font-weight:bold;
margin: 0;
list-style: none;
z-index: 100;
}

#nav div ul li {
margin-bottom: 0;
width:240px;
}

#nav ul li{width:200px;float:left}
#nav ul li ul{width:200px;float:left}
/* 3 уровень*/
#nav ul ul{font-weight:normal}
#nav div ul li a{display: inline-block;white-space: normal;
width: 50%;}
#nav div ul ul li a{height: auto;}
/* 3 уровень end*/
#nav li {
display: block;
position: relative;
}
#nav li div {
position: absolute;
top: 15px;
left: -9999px;
width: 796px !important;
background:rgba(85,85,85,.7);//#555;
    border: 2px solid #fda701;
    border-radius: 15px;
}
.brands div {
z-index: 100;
padding-top: 5px;
}
#nav div{
background:#fff;
opacity:0.9;
padding-bottom: 9px;
}
#nav div li {
width:250px;

}
#nav div ul{
margin-top:6px;
margin-bottom:5px;
}
#nav div li a{
width:230px !important;
text-align:left;
border-left:none;
margin-left:14px;
display:block;
color:#fff;
border:none;
}
#nav div li ul li a{
width:190px !important;
}


#nav div li a:hover{
color:#fda701;
-webkit-transition:color 1s;
-moz-transition:color 1s;
-o-transition:color 1s;
transition:color 1s;
}
.brands li {
border: none !important;
}
.brands a {
padding: 6px 0 0 10px;
    text-align: left;
    width: 150px;
    margin: 0 auto;
    display: block;
    color: #555;
    height: 24px;
    text-decoration: none;
    color: #343434;
    vertical-align: middle;
    white-space: nowrap;
	border: 2px solid #e9e9ea;
}

.brands a:hover:after {
content:\"\\27A4\";
float:right;
color:#fda701;
-webkit-transition: 1s;
-moz-transition:1s;
-o-transition:1s;
transition: 1s;
}

.brands a:hover {
background: #343434;
color:#fda701;
border: 2px solid #fda701;
-webkit-transition:background  1s;
-moz-transition:background  1s;
-o-transition:background 1s;
transition:background 1s;
}
.brands a:hover {
border-radius:15px;
}
li.hover{}
#nav li.hover div {left:200px;top:-13px}"),
"tpl_replace"=>array("<!--kvn_catalog_menu-->"=>"<?php load_module(\"catalog_menu\", 0); ?>"),
"submenu"=>array(1 => 'Разделы', 2 => 'Подразделы', 3 => 'Позиции', 4 => 'Обработка фото', 5 => 'Описания',6=>'Бренды',7=>'Загрузка текстов'),
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
  `name` varchar(255) NOT NULL,
  `altname` text NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `showmenu` int(11) NOT NULL,
  `position` tinyint(3) unsigned NOT NULL,
  `section_id` int(11) unsigned  NOT NULL,
  PRIMARY KEY (`id`),
  KEY `section_id` (`section_id`),
  KEY `name` (`name`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."catalog_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oem` text NOT NULL,
  `name` text NOT NULL,
  `section_id` varchar(255) NOT NULL,
  `subsection_id` varchar(128) NOT NULL,
  `brand_id` int(11) unsigned NOT NULL,
  `model` varchar(32) NOT NULL,
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
  `section` varchar(128) NOT NULL DEFAULT '0',
  `av` int(11) NOT NULL DEFAULT '0',
  `country` text NOT NULL,
  `provider` varchar(32) NOT NULL DEFAULT '',
  `column1` varchar(256) NOT NULL DEFAULT '0',
  `column2` varchar(256) NOT NULL DEFAULT '0',
  `column3` varchar(256) NOT NULL DEFAULT '',
  `column4` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `section_id` (`section_id`),
  KEY `subsection_id` (`subsection_id`),
  KEY `section` (`section`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."catalog_items2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `characteristics` text NOT NULL,
  `specification` text NOT NULL,
  `linked_item` text NOT NULL,
  `keywords` text NOT NULL,
  `subsection_id` varchar(255) NOT NULL,
  `section` varchar(255) NOT NULL,
  `alt` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `section` (`section`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."catalog_models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `altname` text NOT NULL,
  `image` text NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `showimg` int(11) NOT NULL,
  `position` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
)","CREATE TABLE IF NOT EXISTS `".$PREFIX."catalog_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `altname` varchar(255) NOT NULL,
  `level` tinyint(3) unsigned NOT NULL,
  `parent` int(11) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `info` text NOT NULL,
  `showmenu` int(11) NOT NULL,
  `position` tinyint(3) unsigned NOT NULL,
  `img` varchar(128) NOT NULL,
  `sortby` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `altname` (`altname`),
  KEY `parent` (`parent`),
  KEY `showmenu` (`showmenu`)
)","INSERT INTO `".$PREFIX."modules` (`module`, `position`, `ordering`, `admin`,`name`) VALUES('catalog_menu', 'catalog_menu', 4, 0,'catalog_menu')")
);
?>