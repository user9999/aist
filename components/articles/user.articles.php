<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
$script="<script src=\"/js/tree.js\"></script>
<script>
onload = function() { tree(\"tree\", \"http://www.biorow.com/ajax/tree.php\") }
</script>";
set_script($script);
$res=mysql_query("select a.package,a.payed_till,b.access from ".$GLOBALS[PREFIX]."users as a, ".$GLOBALS[PREFIX]."packages as b where a.package=b.id and a.id=".$_SESSION['userid']." limit 1");
//echo "select a.package,b.access from users as a, packages as b where a.package=b.id and a.id=".$_SESSION['userid']." limit 1";
$row=mysql_fetch_row($res);
$permission=unserialize($row[2]);
$payed_till=$row[1];
function showNews()
{
    //echo "select a.id,b.title from articles as a,lang_text as b where a.id=b.rel_id and b.table_name='articles' and a.level=0 and b.language='{$GLOBALS[userlanguage]}' order by a.position";
    echo "<div class=arttree><ul class=\"Container\" id=\"tree\">";
    $res = mysql_query("select a.id,b.title from ".$GLOBALS[PREFIX]."articles as a,lang_text as b where a.id=b.rel_id and b.table_name='articles' and a.level=1 and b.language='{$GLOBALS[userlanguage]}' order by a.position");
    while($row=mysql_fetch_row($res)){
        echo "<li id=\"{$row[0]}\" class=\"Node ExpandClosed\">
	<div class=\"Expand\"></div>
	<div class=\"Content\"><a href=\"/articles/{$row[0]}\">{$row[1]}</a></div>
	<ul class=\"Container\"></ul>
	</li>";
    }
    echo "</ul></div>";
}
function showPackets()
{
    global $userlanguage;
    render_to_template("components/packages/template.showPackages.php", array('title'=>$GLOBALS['dblang_package'][$GLOBALS['userlanguage']]));
}


function showItem($id)
{
    $res = mysql_query("SELECT a.id, a.`date`, b.`title`, b.`content`, b.`short`, b.`description`, b.`keywords` FROM ".$GLOBALS[PREFIX]."articles as a, ".$GLOBALS[PREFIX]."lang_text as b where a.id = $id and a.id=b.rel_id and b.table_name='articles' and b.language='{$GLOBALS[userlanguage]}'");
    if ($row = mysql_fetch_row($res)) {
        set_title(strip_tags($row[2]));
        set_meta($row[6], $row[5]);
        render_to_template("components/articles/template.showItem.php", array('id' => $row[0], 'title' => strip_tags($row[2]), 'date' => $row[1], 'text' => $row[3]));
    } else {
        header("Location: " . $GLOBALS['PATH'] . "/404"); 
    }
}
//var_dump($_GET);
if (!isset($_GET['id'])) { 
    showNews();
} elseif($_GET['id']=='paypal') {
    $package_id=intval($_POST['package']);
    $res1=mysql_query("select a.price,b.title,b.content from packages as a, lang_text as b where b.language='{$GLOBALS['userlanguage']}' and a.id=b.rel_id and b.table_name='packages' and a.id=".$_POST['package']." limit 1");
    $row1=mysql_fetch_row($res1);
    $price=number_format($row1[0], 2, '.', '');
    mysql_query("insert into ".$GLOBALS[PREFIX]."payment set userid={$_SESSION['userid']}, package_id=$package_id, order_date='".time()."',price='{$price}'");
    $pay_id=mysql_insert_id();
    render_to_template("components/packages/template.button.php", array('package_id' => $package_id,'price'=>$price,'title'=>$row1[1],'content'=>$row1[2],'userid'=>$_SESSION['userid'],'pay_id'=>$pay_id));
} elseif(array_key_exists('articles', $permission)) {
    if(($payed_till-time())>(60*60*24*7)) {
        showItem((int) $_GET['id']);
    } elseif(($payed_till-time())>0) {
        $remain=date("H:i:s", ($payed_till-time()));
        echo $GLOBALS['dblang_remain'][$GLOBALS['userlanguage']]." ".$remain."<br>";
        showPackets();
        showItem((int) $_GET['id']);
    } else {
        showPackets();
    }
} else {
    showPackets();
}

//echo "articles";
?>
