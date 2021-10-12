<?php
//we don't use view-controller model here, because this file is very simple
if (!defined("SIMPLE_CMS")) {
    die("Access denied");
}
echo "<ul id=\"nav\" class=\"brands\">\n";
$res = mysql_query("SELECT * FROM catalog_brands WHERE showmenu = 1 ORDER BY position,altname,name");
while ($row = mysql_fetch_row($res)) {
    $style=(strlen($row[2])>16)?" style=\"width:162px;\"":"";
    if ($row[2]) {
        $textrow = $row[2];
    } else {
        $textrow = $row[1];
    }
    echo "<li$style><a href=\"{$GLOBALS['PATH']}/catalog/" . strtolower($row[1]) . "\">{$textrow}</a><div><ul>\n";
    $res2 = mysql_query("SELECT * FROM catalog_models WHERE brand_id = " . $row[0] . " ORDER BY position");//altname, name
    while ($row2 = mysql_fetch_row($res2)) {
        if ($row2[3]) {
            $textrow = $row2[3];
        } else {
            $textrow = $row2[2];
        }
        $textrow=($_GET['t']==$textrow)?"<b>".$textrow."</b>":$textrow;
        echo "<li><a href=\"{$GLOBALS['PATH']}/catalog/product-{$row2[0]}\">{$textrow}</a></li>\n";
    }
            
    echo "</ul></div></li>\n";
}
echo "</ul>";
