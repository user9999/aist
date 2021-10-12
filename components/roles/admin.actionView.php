<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) {
    die("Access denied");
}

?>
<h1>Существующие записи</h1>
<?php

/*
//Вывод в таблицу рекурсивную
$recurse=helpFactory::activate('queries/QueryRecursive');
$array=$recurse->makeQuery('admin_users','','id,name,login,password,phone,email,data,reg_date,active','ORDER BY id');//
$table1=helpFactory::activate('queries/Visitor/FormatRecursive','table');
$table1->link="/admin/?component=admin_users";
$table1->tableSettings=array(array('id','name','login','password','phone','email','data','reg_date','active','Действие'),array("?component=admin_users&action=Edit&table=admin_users&edit="=>"id","?component=admin_users&action=Edit&table=admin_users&del="=>"id","?component=admin_users&action=Add&table=admin_users&add="=>"id"));
$out=$table1->format($recurse);
echo $out;
*/
//Вывод в таблицу не рекурсивное(Раскоментировать)
$table=helpFactory::activate('html/Table');
$actions=array("/admin/?component=roles&action=Edit&edit="=>"id","/admin/?component=roles&del="=>"id");
$table->setType('flex');
$check=array('id'=>'id','name'=>'роль');
$result=$table->makeTable('roles', $check, "admin roles", $actions, true);
if (isset($_GET['del'])) {
    $id=intval($_GET['del']);
    mysql_query("DELETE FROM ".$PREFIX."roles WHERE id='{$id}'");
}
$res = mysql_query("select * from ".$PREFIX."roles");
$num = 0;
while ($row = mysql_fetch_array($res)) {
    $num++;
}
if ($num == 0) {
    echo "Записи не добавлены";
}
?>
