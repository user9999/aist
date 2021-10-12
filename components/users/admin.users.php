<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 
$arr = array(1 => 'Добавление клиента', 2 => 'Меню клиента', 3 => 'Прайс-лист', 4 => 'Настройки', 5 => 'Рассылка', 6 => 'Подписчики');
/*menu_array*/



$action = 1;
if (isset($_GET['action'])) {
    $action = (int) $_GET['action'];
    $action=(array_key_exists($action, $arr))?$action:1;
}

//render list of actions
renderActions($action, $arr,'users');
require "admin.users$action.php";
?>
