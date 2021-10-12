<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
}
$arr=array(1=>'Добавление статьи',2=>'Настройки оплаты');
/*menu_array*/
function renderActions($id,$arr)
{
    foreach($arr as $k=>$v){
        if($k == $id) {
            echo "<b><a href='{$GLOBALS['PATH']}/admin/?component=articles&action=$k'>$v</a></b> &nbsp; &nbsp;";
        } else {
            echo "<a href='{$GLOBALS['PATH']}/admin/?component=articles&action=$k'>$v</a> &nbsp; &nbsp;";
        }
    }
}
$action = 1;
if(isset($_GET['action'])) {
    $action=(int) $_GET['action'];
    $action=(array_key_exists($action, $arr))?$action:1;
}
renderActions($action, $arr);
require "admin.action$action.php";