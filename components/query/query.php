<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
$arr = array('default'=>$GLOBALS['dblang_default'][$GLOBALS['userlanguage']],'view'=>$GLOBALS['dblang_view'][$GLOBALS['userlanguage']],);
/*menu_array*/
$action=(isset($csection))?$csection:'default';

if (isset($action)) {
    $action =($action=="default" || $action=="view" || $action=="edit" || $action=="add")?$action:intval($action);
    //$default=(array_key_exists('view', $arr))?'view':1;
    $action=(array_key_exists($action, $arr))?$action:'default';
}
//render list of actions
renderActions($action, $arr, 'query', false);
$action=ucfirst($action);
//echo "action$action.php";
require "action$action.php";
?>