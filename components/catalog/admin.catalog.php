<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 
$arr = array(6 => 'Управление разделами', 1 => 'Управление брендами', 2 => 'Управление моделями', 3 => 'Управление позициями', 4 => 'Обработка фото', 5 => 'Описания');
/*menu_array*/
function renderActions($id,$arr)
{
    foreach ($arr as $k => $v) {
        if ($k == $id) {
            echo "<b><a href='{$GLOBALS['PATH']}/admin/?component=catalog&action=$k'>$v</a></b> &nbsp; &nbsp;";
        } else {
            echo "<a href='{$GLOBALS['PATH']}/admin/?component=catalog&action=$k'>$v</a> &nbsp; &nbsp;";
        }
    }
}


$action = 6;
if (isset($_GET['action'])) {
    $action = (int) $_GET['action'];
    $action=(array_key_exists($action, $arr))?$action:1;
}

//render list of actions
renderActions($action, $arr);
require "admin.action$action.php";
?>

