<?php if (!defined("SIMPLE_CMS")) die("Access denied"); 
$arr = array('View'=>'Просмотр',);
/*menu_array*/
function renderActions($id,$arr) {
	foreach ($arr as $k => $v) {
		if ($k == $id) {
			echo "<b><a href='{$GLOBALS['PATH']}/test/$k'>$v</a></b> &nbsp; &nbsp;";
		} else {
			echo "<a href='{$GLOBALS['PATH']}/test/$k'>$v</a> &nbsp; &nbsp;";
		}
	}
}
$default=(array_key_exists('View', $arr))?'View':1;
$action = $default;
if (isset($_GET['action'])) {
	$action = (int) $_GET['action'];
	$default=(array_key_exists('view', $arr))?'view':1;
	$action=(array_key_exists($action, $arr))?$action:$default;
}
//render list of actions
renderActions($action,$arr);
include("action$action.php");
?>