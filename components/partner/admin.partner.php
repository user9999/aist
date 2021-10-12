<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
}
$arr=array(1=>'Правила',2=>'Настройки',3=>'Выплаты',4=>'Партнеры',5=>'Сообщения');
/*menu_array*/

$action = 1;
if(isset($_GET['action'])) {
    $action=(int) $_GET['action'];
    $action=(array_key_exists($action, $arr))?$action:1;
}
renderActions($action, $arr,'partner');
require "admin.action$action.php";
?>
