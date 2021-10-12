<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) die("Access denied");
$table=helpFactory::activate('html/Table');
//$check=array('text'=>'название','path'=>'alias', 'ordering'=>'порядок','display'=>'отображать');
$actions=array("/admin/?component=order&action=Edit&edit="=>"id","/admin/?component=menu&del="=>"id");
//$table->setType('table','admin menu');
$table->setType('flex');
//$queryTables=helpFactory::activate('queries/QueryTables');
//$queryOut=$queryTables->makeQuery('menu_admin',$check,true);
//$MyTable=helpFactory::activate('queries/Visitor/TableHTML',array('admin menu',$actions));
//$Tab=helpFactory::activate('queries/Visitor/TableHTML',array('admin menu table table-striped responsive-utilities jambo_table bulk_action',$actions));
//echo $queryTables->makeOutput($Tab);

$check=array('id'=>'№','name'=>'Имя','phone'=>'Тел', 'address'=>'адрес','email'=>'Email','date'=>'дата','total_price'=>'Цена');
//$table->serialized=array('text'=>'ru');
$result=$table->makeTable('order',$check,"admin order",$actions,true);
?>
