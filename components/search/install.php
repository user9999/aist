<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installSearch=array("name"=>"Поиск",
"description"=>"",
"install"=>"",
"tpl_replace"=>array("<!--kvn_search-->"=>"<form method=\"get\" action=\"/search\">
<div class=search>
<input name=\"frm_searchfield\" type=text>
<input type=\"submit\" value=\"\" class=\"button\">
</div>
</form>"),
"css_replace"=>array("/*search*/"=>"*:focus {
    outline: none;
}
.search {
    width: 460px;
    height: 30px;
    float: left;
    margin-top: 20px;
    background: #E9E9EA;
    border: 3px inset #ccc;
    border-radius: 18px;
}
.search input[type=\"text\"] {
    width: 410px;
    height: 27px;
    border: none;
    background:transparent;
    margin-left: 12px;
    float: left;
    font-size: 20px;
    color:#555;
}
input.button {
    cursor: pointer;
    height: 30px;
    width: 30px;
    border: 0px;
    background:url('img/search.png') no-repeat top left;
}"),
"queries"=>array()
);
?>