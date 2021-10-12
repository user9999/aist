<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) die();
$installQuery=array("name"=>"запросы",
"description"=>"Ajax поиск. Включает файлы /ajax/search.php; /js/search.js; /templates/blank/search.css",
"install"=>"",
"tpl_replace"=>array("<!--kvn_search-->"=>"<!--kvn_search-->\r\n<div class=\"search search_box\">
<form method=\"get\" action=\"/query\">
<input name=\"frm_searchfield\" id=\"search\" type=text autocomplete=\"off\">
<input type=\"submit\" value=\"\" class=\"button\">
</form>
<div id=\"search_box-result\"></div>
</div>\r\n","<!--kvn_css-->","<!--kvn_css-->\r\n<link rel=\"stylesheet\" href=\"/templates/<?=\$TEMPLATE?>/search.css\">",
"<!--kvn_scripts-->"=>"<!--kvn_scripts-->\r\n<script type=\"text/javascript\" src=\"<?=\$PATH?>/js/search.js\"></script>\r\n"),
"css_replace"=>array(),
"index_replace"=>array(),
"submenu"=>array('View'=>'Просмотр','Add'=>'Добавление','Edit'=>'Редактирование',),
"queries"=>array("CREATE TABLE IF NOT EXISTS `".$PREFIX."queries` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,phrase varchar(255) NOT NULL,url varchar(255) NOT NULL)","INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('запросы', 'query', 60, 1)"),
);
?>