<?php if (!defined("ADMIN_SIMPLE_CMS")) {
    die("Access denied");
}
$arr = array(1 => 'Статьи-галереи', 2 => 'Обработка фото', 3 => 'Загрузка фото');
$arr = array(1 => 'Статьи-галереи',2 => 'Обработка фото',3 => 'Загрузка фото',);
/*menu_array*/


$action = 1;
if (isset($_GET['action'])) {
    $action = (int) $_GET['action'];
    $action=(array_key_exists($action, $arr))?$action:1;
}

//render list of actions
renderActions($action, $arr, 'farms');
require "admin.action$action.php";
?>

