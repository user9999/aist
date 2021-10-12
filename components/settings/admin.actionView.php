<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) {
    die("Access denied");
}

?>
<h1>Существующие записи</h1>
<p>Вызов в шаблоне: &lt;?php echo get_settings('alias')?&gt;</p> 


<?php
$res = mysql_query("select * from ".$PREFIX."settings");
$num = 0;
while ($row = mysql_fetch_row($res)) {
    $num++;
}
if ($num == 0) {
    echo "Записи не добавлены";
}

$table=helpFactory::activate('html/Table');
$check=array('alias'=>'Alias','value1'=>'Значение 1','value2'=>'Значение 2','value3'=>'Значение 3');
$actions=array("/admin/?component=settings&action=Edit&edit="=>"id","/admin/?component=settings&del="=>"id");
$table->setType('flex');
$result=$table->makeTable('settings', $check, "admin settings", $actions, true);
?>