<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) die("Access denied");
?>
<h1>Существующие записи</h1>
<?php
$res = mysql_query("select * from ".$PREFIX."test");
$num = 0;
while ($row = mysql_fetch_row($res)) {
	$tt=$row[1];
$res1=mysql_query("SELECT title FROM ".$PREFIX."lang_text where table_name='test' and rel_id={$row[0]} and language='{$GLOBALS[DLANG]}'");
	while($row1=mysql_fetch_row($res1)){
		$tt=$row1[0];
		break;
	}
	$num++;
    echo $tt . " (" . $row[1] . ") <a href='?component=test&action=edit&edit={$row[0]}'>[редактировать]</a> <a href='?component=test&action=edit&del={$row[0]}'>[удалить]</a><br />";
}
if ($num == 0) echo "Страницы не добавлены";
?>