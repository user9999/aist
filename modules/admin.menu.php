<?php if (!defined("ADMIN_SIMPLE_CMS")) {
    die("Access denied");
} ?>

<?php
$display=($_SESSION['development']==1)?"":" and display=1";
$query="SELECT text, path FROM ".$PREFIX."menu_admin  WHERE parent_id=0{$display} ORDER BY ordering";
$res = mysql_query($query);
while ($row = mysql_fetch_row($res)) {
    $icon = "images/default-icon.png";
    $link = $GLOBALS['PATH'] . "/admin/?component=" . $row[1];

    if (strpos($_SERVER['REQUEST_URI'], "component=" . $row[1]) !== false) {
        if (file_exists("components/{$row[1]}/icon.png")) {
            $icon = "components/{$row[1]}/icon.png";
        }
        echo "<div class=\"menuitem\"><img align=\"left\" src=\"../$icon\"> &nbsp;<a href='$link'><b>{$row[0]}</b></a></div>";
    } else {
        if (file_exists("components/{$row[1]}/icon.png")) {
            $icon = "components/{$row[1]}/icon.png";
        }

        echo "<div class=\"menuitem\"><img align=\"left\" src=\"../$icon\"> &nbsp;<a href='$link'>{$row[0]}</a></div>";
    }
}
?>
