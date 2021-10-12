<?php
define("ADMIN_SIMPLE_CMS", 1);

//include configuration
require_once("inc/configuration.php");
require_once("inc/functions.php");
require_once("classes/HelpFactory.php");
$TPL=$ADMIN_TEMPLATE;
$userlanguage=$DLANG;
if (!isset($_GET['component'])) header("Location: $PATH/admin/?component=index");
session_start();

//select component
$component = "index";
if (isset($_GET['component']) && preg_match("/^[а-яa-zA-Z0-9_]+$/", $_GET['component'])) {
    $component = $_GET['component'];
    if (!file_exists("components/$component/admin.$component.php")) $component = "index";
}

//include component
if (!isset($_SESSION['admin_name'])) $component = "login";

ob_start();
set_css('');
set_script('');
if(file_exists("components/$component/tpl/css/admin.css")) {
    set_css($component."/tpl/css/admin.css", 1);
}
if(file_exists("components/$component/tpl/js/admin.js")) {
    set_script($component."/tpl/js/admin.js", 1);
}
include("components/$component/admin.$component.php");
$PAGE_BODY = ob_get_contents();
ob_clean();

//include template
if (file_exists("templates/$ADMIN_TEMPLATE/$component.template.php")) {
    include("templates/$ADMIN_TEMPLATE/$component.template.php");

} else {

    include("templates/$ADMIN_TEMPLATE/template.php");
}
?>
