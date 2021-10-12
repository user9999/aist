<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 
$arr = array(1 => 'Загрузка', 2 => 'Редактирование', 3 => 'Настройки');
$arr = array(1 => 'Загрузка',2 => 'Редактирование',3 => 'Настройки',);
$arr = array(1 => 'Загрузка',2 => 'Редактирование',3 => 'Настройки',);
/*menu_array*/

$action = 1;
if (isset($_GET['action'])) {
    $action = (int) $_GET['action'];
    $action=(array_key_exists($action, $arr))?$action:1;
}
//render list of actions
renderActions($action, $arr,'gallery');
require "admin.action$action.php";
?>