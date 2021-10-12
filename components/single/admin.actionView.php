<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
}

?>
<h1>Существующие записи</h1>
<?php
$res = mysql_query("select * from ".$PREFIX."single");
$num = 0;
while ($row = mysql_fetch_row($res)) {
    $tt=$row[1];
    $num++;
    echo $tt . " (" . $row[1] . ") <a href='?component=single&action=Edit&table=single&edit={$row[0]}'>[редактировать]</a> <a href='?component=single&action=Edit&table=single&del={$row[0]}'>[удалить]</a><br />";
}
if ($num == 0) { echo "Записи не добавлены";
}
?>