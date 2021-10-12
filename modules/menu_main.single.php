<?php
//we don't use view-controller model here, because this file is very simple
if (!defined("SIMPLE_CMS")) {
    die("Access denied");
}

$res = mysql_query("SELECT text, path, ordering FROM ".$PREFIX."menu".$GLOBALS['TBL']." ORDER BY ordering");
$i = 0;
if ($_SESSION['admin_name']) {
    echo "<div class=\"menuitem\"><a href='".$GLOBALS['PATH']."/admin/?component=users'>Админка</a><div class=\"div\"></div></div>";
}
while ($row = mysql_fetch_row($res)) {
    if (strpos($_SERVER['REQUEST_URI'], $row[1]) !== false) {
        $row[0] = "<span class=active>" . $row[0] . "</span>";
    }
    if ($row[1]=="reserve" || $row[1]=="preorder") {
        if ($_SESSION['actype'][1]==1 && $row[1]=="reserve") {
        
            //echo "<td><a href='" . $GLOBALS['PATH'] . "/{$row[1]}'>{$row[0]}</a></td>";
            echo "<div class=\"menuitem\"><a href='".$GLOBALS['PATH']."/{$row[1]}'>{$row[0]}</a><div class=\"div\"></div></div>";
        }
        if ($_SESSION['actype'][5]==1 && $row[1]=="preorder") {
        
            //echo "<td><a href='" . $GLOBALS['PATH'] . "/{$row[1]}'>{$row[0]}</a></td>";
            echo "<div class=\"menuitem\"><a href='".$GLOBALS['PATH']."/{$row[1]}'>{$row[0]}</a><div class=\"div\"></div></div>";
        }
    } else {
        //echo "<td><a href='" . $GLOBALS['PATH'] . "/{$row[1]}'>{$row[0]}</a></td>";
        echo "<div class=\"menuitem\"><a href='".$GLOBALS['PATH']."/{$row[1]}'>{$row[0]}</a><div class=\"div\"></div></div>";
    }
}
