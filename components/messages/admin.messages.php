<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) die("Access denied"); 
$arr = array('View'=>'Просмотр','Edit'=>'Редактирование',);
/*menu*/

$default=(array_key_exists('View', $arr))?'View':1;
$action = $default;
if (isset($_GET['action'])) {
    $action =($_GET['action']=="View" || $_GET['action']=="Edit" || $_GET['action']=="Add")?$_GET['action']:intval($_GET['action']);
    $default=(array_key_exists('View', $arr))?'View':1;
    $action=(array_key_exists($action, $arr))?ucfirst($action):$default;
}
//render list of actions
renderActions($action,$arr,'messages');
include($HOSTPATH."/components/messages/lang/lang.php");
include("admin.action$action.php");
?>