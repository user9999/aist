<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 
function renderActions($id)
{
    $arr = array(1 => 'Предв. заказы', 2 => 'История');
    foreach ($arr as $k => $v) {
        if ($k == $id) {
            echo "<b><a href='{$GLOBALS['PATH']}/admin/?component=preorder&action=$k'>$v</a></b> &nbsp; &nbsp;";
        } else {
            echo "<a href='{$GLOBALS['PATH']}/admin/?component=preorder&action=$k'>$v</a> &nbsp; &nbsp;";
        }
    }
}


$action = 1;
if (isset($_GET['action'])) {
    $action = (int) $_GET['action'];
    if ($action > 2 || $action < 1) { $action = 1;
    }
}

//render list of actions
renderActions($action);
?>
