<?php
if (!defined("ADMIN_SIMPLE_CMS")) die("Access denied"); 
$arr = array('View'=>'Просмотр','Add'=>'Добавление','Edit'=>'Редактирование',);
/*menu_array*/
function renderActions($id,$arr) {
	foreach ($arr as $k => $v) {
		if ($k == $id) {
			echo "<b><a href='{$GLOBALS['PATH']}/admin/?component=query&action=$k'>$v</a></b> &nbsp; &nbsp;";
		} else {
			echo "<a href='{$GLOBALS['PATH']}/admin/?component=query&action=$k'>$v</a> &nbsp; &nbsp;";
		}
	}
}
$default=(array_key_exists('View', $arr))?'View':1;
$action = $default;
if (isset($_GET['action'])) {
	$action =($_GET['action']=="View" || $_GET['action']=="Edit" || $_GET['action']=="Add")?$_GET['action']:intval($_GET['action']);
	$default=(array_key_exists('View', $arr))?'View':1;
	$action=(array_key_exists($action, $arr))?ucfirst($action):$default;
}
//render list of actions
renderActions($action,$arr);
include($HOSTPATH."/components/query/lang/lang.php");
include("admin.action$action.php");
?>