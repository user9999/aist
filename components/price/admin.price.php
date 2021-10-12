<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 
$arr = array(1 => 'Управление позициями', 2 => 'Импорт товаров', 3 => 'Цены и города', 4 => 'СПб', 5 => 'Москва');//, 3 => 'Цены и города', 4 => 'СПб', 5 => 'Москва'
/*menu_array*/

$action = 1;
if (isset($_GET['action'])) {
    $action = (int) $_GET['action'];
    $action=(array_key_exists($action, $arr))?$action:1;
}
//render list of actions
renderActions($action, $arr,'price');
require "admin.action$action.php";
?>

