<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
$permitted=1; //=0 статьи платные!
$script="<script src=\"/js/tree.js\"></script>
<script>
onload = function() { tree(\"tree\", \"/ajax/tree.php\") }
</script>";
set_script($script);
$css="<link rel=\"stylesheet\" href=\"/css/tree.css\">
";
//var_dump($_GET['id']);
//$_GET['id']=intval($segments[1]);
//echo $_GET['id'];
//set_css($css);
function showNews()
{
    echo "<div class=arttree><ul class=\"Container\" id=\"tree\">";
    //echo "select a.id,b.title from ".$GLOBALS[PREFIX]."articles as a,".$GLOBALS[PREFIX]."lang_text as b where a.id=b.rel_id and b.table_name='articles' and a.level=1 and b.language='{$GLOBALS[userlanguage]}' order by a.position";
    $res = mysql_query("select a.id,b.title from ".$GLOBALS[PREFIX]."articles as a,".$GLOBALS[PREFIX]."lang_text as b where a.id=b.rel_id and b.table_name='articles' and a.level=1 and b.language='{$GLOBALS[userlanguage]}' order by a.position");
    while($row=mysql_fetch_row($res)){
        echo "<li id=\"{$row[0]}\" class=\"Node ExpandClosed\">
	<div class=\"Expand\"></div><div class=\"Content\"><a href=\"/articles/{$row[0]}\">{$row[1]}</a></div><ul class=\"Container\"></ul></li>";
    }
    echo "</ul></div>";
}
function showItem($id)
{
    $res = mysql_query("SELECT a.id, a.`date`, b.`title`, b.`content`, b.`short`, b.`description`, b.`keywords` FROM ".$GLOBALS[PREFIX]."articles as a, ".$GLOBALS[PREFIX]."lang_text as b where a.id = $id and a.id=b.rel_id and b.table_name='articles' and b.language='{$GLOBALS[userlanguage]}'");
    if ($row = mysql_fetch_row($res)) {
        set_title(strip_tags($row[2]));
        set_meta($row[6], $row[5]);
        render_to_template("components/articles/template.showArticles.php", array('id' => $row[0], 'title' => strip_tags($row[2]), 'date' => $row[1], 'text' => $row[3]));
    } else {
        header("Location: " . $GLOBALS['PATH'] . "/404"); 
    }
}

if (!isset($_GET['id'])) {
    showNews(); 
} elseif($permitted) {
    showItem((int) $_GET['id']);
} else {
    echo "<div class=error>".$GLOBALS['dblang_authorize'][$GLOBALS['userlanguage']]."</div>";
}
//showItem(intval($segments[1]));////showItem($_GET['id']);// echo $GLOBALS['dblang_authorize'][$GLOBALS['userlanguage']];//showItem((int) $_GET['id']);

//echo "articles";
?>
