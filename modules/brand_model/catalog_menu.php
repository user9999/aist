<?php
//we don't use view-controller model here, because this file is very simple
if (!defined("SIMPLE_CMS")) {
    die("Access denied");
}


//echo $_GET['t'];
    $res = mysql_query("SELECT * FROM catalog_brands WHERE showmenu = 1 ORDER BY altname, name");
while ($row = mysql_fetch_row($res)) {
    if ($row[2]) {
        $textrow = $row[2];
    } else {
        $textrow = $row[1];
    }
        
    //echo "<div class=\"menuitem\"><a href=\"javascript:showItem({$row[0]});\">{$textrow}</a>";
    echo "<div class=\"menuitem\"><a href=\"{$GLOBALS['PATH']}/catalog/" . strtolower($row[1]) . "\">{$textrow}</a> <span id='sp_{$row[0]}'><img src='http://img.gruz-zap.ru/templates/blank/img/up.gif' alt=''></span>";

    echo "<div class=\"menus pos_" . strtolower($row[1]) . "\" id='show_{$row[0]}'>";
        
    $res2 = mysql_query("SELECT * FROM catalog_models WHERE brand_id = " . $row[0] . " ORDER BY position");//altname, name
    while ($row2 = mysql_fetch_row($res2)) {
        if ($row2[3]) {
            $textrow = $row2[3];
        } else {
            $textrow = $row2[2];
        }
        $textrow=($_GET['t']==$textrow)?"<b>".$textrow."</b>":$textrow;
        echo "<div class=\"menuitem2\" id=\"model_{$row2[0]}\"><a href=\"{$GLOBALS['PATH']}/catalog/model-{$row2[0]}\">{$textrow}</a></div>";
    }
    echo "</div>";
            
    echo "<div class=\"div\"></div></div>";
}

?>

<form method="get" action="<?php echo $GLOBALS['PATH'] ?>/search">
    <div style="margin: 20px; margin-top: 15px; margin-bottom: 0px;">
        <input type="text" name="frm_searchfield" style="width: 100%;">
        <input type="submit" value="Поиск" class="button" style="padding-top: 2px;">
        <a class="asearch" href="<?php echo $GLOBALS['PATH'] ?>/search">Расширенный поиск</a>
    </div>
</form>
