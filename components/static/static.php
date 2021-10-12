<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
} ?>
<?php
if (!isset($_GET['id'])) { header("Location: " . $GLOBALS['PATH'] . "/404");
}
$contacts=false;
$id = preg_replace("/[^a-z0-9]/", "", $_GET['id']);
$field=($MY_URL==1)?'id':'path';
//$res = mysql_query("SELECT * FROM ".$PREFIX."static WHERE path='$id'");
$res = mysql_query("SELECT a.id, b.title,b.content,b.description,b.keywords FROM ".$PREFIX."static as a, ".$PREFIX."lang_text as b where a.id=b.rel_id and b.table_name='static' and b.language='{$GLOBALS[userlanguage]}' and a.{$field}='$id'");//"SELECT * FROM static WHERE path='$id'"

if ($row = mysql_fetch_row($res)) {
    set_title($row[1]);
    set_meta($row[4], $row[3]);
    render_to_template("components/static/template.static.php", array('title' => $row[1], 'text' => $row[2], 'contacts' => $contacts));
} else { header("Location: " . $GLOBALS['PATH'] . "/404");
} 
?>
