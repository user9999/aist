<?php if (!defined("SIMPLE_CMS")) die("Access denied"); 
$arr = array();
/*menu_array*/
$action=(isset($csection))?$csection:'default';
if (isset($action)) {
    $action =($action=="default" || $action=="view" || $action=="edit" || $action=="add")?$action:intval($action);
    //$default=(array_key_exists('view', $arr))?'view':1;
    $action=(array_key_exists($action, $arr))?$action:'default';
}
//render list of actions
renderActions($action,$arr,'forms',false);
$action=ucfirst($action);
include("user.action$action.php");
?>