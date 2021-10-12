<?php
if (!defined("ADMIN_SIMPLE_CMS")) {
    die("Access denied");
}
$arr = array('View'=>'Просмотр','Add'=>'Добавление','Edit'=>'Редактирование'); //,'Edit'=>'Редактирование'
$arr = array(View => 'Просмотр',Add => 'Добавление',Edit => 'Редактирование',1 => 'Изменить',);
/*menu_array*/

$default=(array_key_exists('View', $arr))?'View':1;
$action = $default;
if (isset($_GET['action'])) {
    $action =($_GET['action']=="View" || $_GET['action']=="Edit" || $_GET['action']=="Add")?$_GET['action']:intval($_GET['action']);
    $default=(array_key_exists('View', $arr))?'View':1;
    $action=(array_key_exists($action, $arr))?ucfirst($action):$default;
}
//render list of actions
renderActions($action, $arr, 'product');
include($HOSTPATH."/components/product/lang/lang.php");
include("admin.action$action.php");
