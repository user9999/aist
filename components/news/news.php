<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
} 

function showNews()
{
    echo "<div class='content_body'><h3>Новости</h3>";
    $res = mysql_query("SELECT a.id, a.`date`,b.title,b.short FROM {$GLOBALS['PREFIX']}news as a, {$GLOBALS['PREFIX']}lang_text as b where a.id=b.rel_id and b.table_name='news' and b.language='{$GLOBALS[userlanguage]}' ORDER BY `date` DESC");
    //set_title("Новости");
    //echo "SELECT a.id, a.`date`,b.title,b.short FROM ".$PREFIX."news as a, ".$PREFIX."lang_text as b where a.id=b.rel_id and b.table_name='news' and b.language='{$GLOBALS[userlanguage]}' ORDER BY `date` DESC";
    set_title($GLOBALS['dblang_news'][$GLOBALS['userlanguage']]);
    while ($row = mysql_fetch_row($res)) {
        render_to_template("components/news/template.showNews.php", array('id' => $row[0], 'title' => $row[2], 'date' => $row[1], 'text' => $row[3]));
    }
    echo "</div>";
}

function showItem($id)
{
    $res = mysql_query("SELECT a.id, a.`date`, b.`title`, b.`content`, b.`short`, b.`description`, b.`keywords` FROM {$GLOBALS['PREFIX']}news as a, {$GLOBALS['PREFIX']}lang_text as b where a.id = $id and a.id=b.rel_id and b.table_name='news' and b.language='{$GLOBALS[userlanguage]}'");
    if ($row = mysql_fetch_row($res)) {
        set_title(strip_tags($row[1]));
        set_meta($row[5], $row[4]);
        render_to_template("components/news/template.showItem.php", array('id' => $row[0], 'title' => strip_tags($row[2]), 'date' => $row[1], 'text' => $row[3]));
    } else {
        header("Location: " . $GLOBALS['PATH'] . "/404"); 
    }
}

if (!isset($_GET['id'])) { showNews(); 
} else { showItem((int) $_GET['id']);
}
?>
