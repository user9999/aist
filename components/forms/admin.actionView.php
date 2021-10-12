<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) {
    die("Access denied");
}

$table=helpFactory::activate('html/Table');
$check=array('id'=>'ID','name'=>'Название', 'tablename'=>'таблица БД','alias'=>'Алиас','enctype'=>'enctype','method'=>'Метод','action'=>'action','attributes'=>'Атрибуты');
$actions=array("/admin/?component=forms&action=Edit&edit="=>"id","/admin/?component=forms&action=AddFields&formid="=>"id","/admin/?component=forms&del="=>"id");
//$table->setType('table','admin menu');
$table->setType('flex');
$queryTables=helpFactory::activate('queries/QueryTables');
$queryOut=$queryTables->makeQuery('forms', $check, true);
//print_r($queryOut);
$Tab=helpFactory::activate('queries/Visitor/TableHTML', array('admin forms table table-striped responsive-utilities jambo_table bulk_action',$actions));
echo $queryTables->makeOutput($Tab);//echo
