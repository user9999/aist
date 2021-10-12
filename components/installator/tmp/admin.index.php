<?php if (!defined("ADMIN_SIMPLE_CMS")) die("Access denied"); 
$arr = array(1 => 'Баннер', 2 => 'Вывод ссылок на 1 страницу', 3 => 'Настройки',4=>"Языки");
$arr = array(1 => 'Баннер',2 => 'Вывод ссылок на 1 страницу',3 => 'Настройки',4 => 'Языки',);
function renderActions($id,$arr) {
	foreach ($arr as $k => $v) {
		if ($k == $id) {
			echo "<b><a href='{$GLOBALS['PATH']}/admin/?component=index&action=$k'>$v</a></b> &nbsp; &nbsp;";
		} else {
			echo "<a href='{$GLOBALS['PATH']}/admin/?component=index&action=$k'>$v</a> &nbsp; &nbsp;";
		}
	}
}

$action = 1;
if (isset($_GET['action'])) {
	$action = (int) $_GET['action'];
	//if ($action > 4 || $action < 1) $action = 1;
	$action=(array_key_exists($action, $arr))?$action:1;
}

//render list of actions
renderActions($action,$arr);
include("admin.action$action.php");
?>