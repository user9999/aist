<?php
if (!defined("SIMPLE_CMS")) {
    die("Access denied");
}
$arr = array('default'=>$GLOBALS['dblang_default'][$GLOBALS['userlanguage']],'view'=>$GLOBALS['dblang_view'][$GLOBALS['userlanguage']],);//'view'=>$GLOBALS['dblang_view'][$GLOBALS['userlanguage']],1 => '',
/*menu_array*/
$action=(isset($csection))?$csection:'default';
/*
function renderActions($id, $arr)
{
    global $ssubmenu;
    foreach ($arr as $k => $v) {
        if ($k == $id && $v) {
            if ($k!='view') {
                $ssubmenu.="<b><a href='{$GLOBALS['PATH']}/product/$k'>$v</a></b> &nbsp; &nbsp;";
            }
        } elseif ($v) {
            if ($k!='view') {
                $ssubmenu.="<a href='{$GLOBALS['PATH']}/product/$k'>$v</a> &nbsp; &nbsp;";
            }
        }
    }
}
 */
if (isset($action)) {
    $action =($action=="default" || $action=="view" || $action=="edit" || $action=="add")?$action:intval($action);
    //$default=(array_key_exists('view', $arr))?'view':1;
    $action=(array_key_exists($action, $arr))?$action:'default';
}
//render list of actions
renderActions($action, $arr, 'product');
$action=ucfirst($action);
//echo   "action$action.php";
include("action$action.php");
