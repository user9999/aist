<?php
//we don't use view-controller model here, because this file is very simple
if (!defined("SIMPLE_CMS")) {
    die("Access denied");
}

$res = mysql_query("SELECT id,text, path, ordering,parent,level FROM ".$PREFIX."menu".$GLOBALS['TBL']."  ORDER BY parent, ordering");
$i = 0;

while ($row = mysql_fetch_row($res)) {
    $point=unserialize($row[1]);
    if ($row[4]==0) {
        //$point[$GLOBALS[userlanguage]];
        $menu[$row[0]]="<li class=menuitem><a href=\"/{$row[2]}\" class=\"mark\">{$point[$GLOBALS[userlanguage]]}</a></li>";
    } else {
        if (strpos($menu[$row[4]], "</ul>")!==false) {
            $menu[$row[4]]=str_replace("</ul></li>", "<li><a href=\"/{$row[2]}\">{$point[$GLOBALS[userlanguage]]}</a></li></ul></li>", $menu[$row[4]]);
        } else {
            $menu[$row[4]]=str_replace("</li>", "<ul class=\"submenu\"><li><a href=\"/{$row[2]}\">{$point[$GLOBALS[userlanguage]]}</a></li></ul></li>", $menu[$row[4]]);
        }
    }

    /*
    if (strpos($_SERVER['REQUEST_URI'], $row[1]) !== false) $row[0] = "<span class=active>" . $row[0] . "</span>";
    if($row[1]=="reserve" || $row[1]=="preorder"){
    if($_SESSION['actype'][1]==1 && $row[1]=="reserve"){

    //echo "<td><a href='" . $GLOBALS['PATH'] . "/{$row[1]}'>{$row[0]}</a></td>";
    echo "<div class=\"menuitem\"><a href='".$GLOBALS['PATH']."/{$row[1]}'>{$row[0]}</a><div class=\"div\"></div></div>";
    }
    if($_SESSION['actype'][5]==1 && $row[1]=="preorder"){

    //echo "<td><a href='" . $GLOBALS['PATH'] . "/{$row[1]}'>{$row[0]}</a></td>";
    echo "<div class=\"menuitem\"><a href='".$GLOBALS['PATH']."/{$row[1]}'>{$row[0]}</a><div class=\"div\"></div></div>";
    }
    } else {
    //echo "<td><a href='" . $GLOBALS['PATH'] . "/{$row[1]}'>{$row[0]}</a></td>";
    echo "<div class=\"menuitem\"><a href='".$GLOBALS['PATH']."/{$row[1]}'>{$row[0]}</a><div class=\"div\"></div></div>";


    }
    */
}
$out="<ul class=menu-top>".implode("", $menu)."</ul>";
echo $out;
