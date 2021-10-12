<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 
$arr = array(0=>'Welcome', 1 => 'Баннер', 2 => 'Вывод ссылок на 1 страницу', 3 => 'Настройки',4=>"Языки");
/*menu_array*/


$action = 0;
if (isset($_GET['action'])) {
    $action = (int) $_GET['action'];
    //if ($action > 4 || $action < 1) $action = 1;
    $action=(array_key_exists($action, $arr))?$action:1;
}

//render list of actions
renderActions($action, $arr,'index');
require "admin.action$action.php";
?>