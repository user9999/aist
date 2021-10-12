<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) die("Access denied");

?>
<h1>Существующие записи</h1>
<?php


//Вывод в таблицу не рекурсивное(Раскоментировать) 
$table=helpFactory::activate('html/Table');
$actions=array("/admin/?component=admin_users&action=Edit&edit="=>"id","/admin/?component=admin_users&del="=>"id");
$table->setType('flex');
$check=array('id'=>'№','id'=>'id','name'=>'Имя','login'=>'Логин','phone'=>'Тел','email'=>'Email','reg_date'=>'Дата','role'=>'Роль','active'=>'Активен');
$result=$table->makeTable('admin_users',$check,"admin admin_users",$actions,true);

$res = mysql_query("select * from ".$PREFIX."admin_users");
$num = 0;
while ($row = mysql_fetch_array($res)) {
$num++;
}
if ($num == 0) echo "Записи не добавлены";
?>
