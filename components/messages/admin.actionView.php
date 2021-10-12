<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) die("Access denied");
$table=helpFactory::activate('html/Table');
$check=array('name'=>'Имя','phone'=>'тел','email'=>'email','theme'=>'Тема','type'=>'Тип','status'=>'статус','date'=>'Время');
$actions=array("/admin/?component=messages&action=Edit&details="=>"id","/admin/?component=messages&action=View&del="=>"id");
$table->setType('flex');
if (isset($_GET['del'])) {
    mysql_query("DELETE FROM ".$PREFIX."messages WHERE id='{$_GET['del']}'");
    }
    /*
if(isset($_GET['done'])){
    mysql_query("UPDATE ".$PREFIX."messages SET status=1 WHERE id='{$_GET['done']}'");
}

     */
?>
<h1>Существующие записи</h1>
<?php
$result=$table->makeTable('messages', $check, "admin messages", $actions, true);
$res = mysql_query("select * from ".$PREFIX."messages");
$num = 0;
while ($row = mysql_fetch_row($res)) {
	$tt=$row[1];
$num++;
   // echo $tt . " (" . $row[1] . ") <a href='?component=messages&action=Edit&table=messages&edit={$row[0]}'>[редактировать]</a> <a href='?component=messages&action=Edit&table=messages&del={$row[0]}'>[удалить]</a><br />";
}
if ($num == 0) echo "Записи не добавлены";
?>