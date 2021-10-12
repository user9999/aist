<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) die("Access denied");
$table=helpFactory::activate('html/Table');
$check=array('title'=>'название','images'=>'изображения','create_time'=>'Время создания','pub_time'=>'Время публикации');
$actions=array("/admin/?component=tidings&action=Edit&edit="=>"id","/admin/?component=tidings&action=Edit&del="=>"id");
$table->setType('flex');
?>
<h1>Существующие записи</h1>
<?php
$res = mysql_query("select * from ".$PREFIX."tidings");
$num = 0;
while ($row = mysql_fetch_row($res)) {
	$tt=$row[1];
$res1=mysql_query("SELECT title FROM ".$PREFIX."lang_text where table_name='tidings' and rel_id={$row[0]} and language='{$GLOBALS[DLANG]}'");
	while($row1=mysql_fetch_row($res1)){
		$tt=$row1[0];
		break;
	}
	$num++;
    //echo $tt . " (" . $row[1] . ") <a href='?component=tidings&action=Edit&table=tidings&edit={$row[0]}'>[редактировать]</a> <a href='?component=tidings&action=Edit&table=tidings&del={$row[0]}'>[удалить]</a><br />";
}
$result=$table->makeTable('tidings', $check, "admin tidings", $actions, true);
if ($num == 0) echo "Записи не добавлены";

?>