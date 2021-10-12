<?php
if (!defined("SIMPLE_CMS")) {
    die("Access denied");
}
$arr = array('default'=>$GLOBALS['dblang_default'][$GLOBALS['userlanguage']],'view'=>$GLOBALS['dblang_view'][$GLOBALS['userlanguage']],);
/*menu_array*/
$action=(isset($csection))?$csection:'default';
function renderActions($id, $arr)
{
    global $ssubmenu;
    foreach ($arr as $k => $v) {
        if ($k == $id && $v) {
            $ssubmenu.="<b><a href='{$GLOBALS['PATH']}/product/$k'>$v</a></b> &nbsp; &nbsp;";
        } elseif ($v) {
            $ssubmenu.="<a href='{$GLOBALS['PATH']}/product/$k'>$v</a> &nbsp; &nbsp;";
        }
    }
}
if (isset($action)) {
    $action =($action=="default" || $action=="view" || $action=="edit" || $action=="add")?$action:intval($action);
    //$default=(array_key_exists('view', $arr))?'view':1;
    $action=(array_key_exists($action, $arr))?$action:'default';
}
//render list of actions
renderActions($action, $arr);
$action=ucfirst($action);
//echo "user.action$action.php";
include("user.action$action.php");
