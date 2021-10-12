<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) {
    die("Access denied");
}

$table=helpFactory::activate('html/Table');
$check=array('id'=>'№','name'=>'Название','alias'=>'Алиас','price'=>'стоимость');

    $qdop='';
    $pid=intval(strip_tags($_GET['pid']));
    if ($pid) {
        $qdop="&pid=$pid";
    }
$actions=array("?component=product&action=Edit&table=product$qdop&edit="=>"id","?component=product&action=Edit&table=product$qdop&del="=>"id","?component=product&action=Add&table=product&add="=>"id");

if (!$pid) {
    $pid=0;
}
function genpath1($id, $tbl)
{
    $r=mysql_query("select * from `kvn_product` where id=$id;");
    $tmp=mysql_result($r, 0, 'pid');
    $s='<a href="?component=product&action=View&table=product&pid='.$id.'">'.mysql_result($r, 0, 'name').'</a>';
    if ($tmp>0) {
        $s=genpath1($tmp, 'product').' &raquo; '.$s;
    }
    return $s;
}

?>
<h1>Изделия</h1>
<?php
if ($pid) {
    echo '<a href=?component=product&action=View&table=product&pid=0>Изделия</a> &raquo; '.genpath1($pid, 'kvn_product').'<hr>';
}

$res = mysql_query("select * from ".$PREFIX."product");
$num = 0;
while ($row = mysql_fetch_array($res)) {
    $tt=$row[1];
    $res1=mysql_query("SELECT title FROM ".$PREFIX."lang_text where table_name='product' and rel_id={$row['id']} and language='{$GLOBALS[DLANG]}'");
    while ($row1=mysql_fetch_row($res1)) {
        $tt=$row1[0];
        break;
    }
    $num++;
    //echo $tt . " (" . $row[1] . ") <a href='?component=product&action=Edit&table=product&edit={$row[0]}'>[редактировать]</a> <a href='?component=product&action=Edit&table=product&del={$row[0]}'>[удалить]</a><br />";
}


$recurse=helpFactory::activate('queries/QueryRecursive');
$array=$recurse->makeQuery('product','pid','id,name,alias,price','ORDER BY id');//
$table1=helpFactory::activate('queries/Visitor/FormatRecursive','table');
$table1->link="/admin/?component=product";
$table1->tableSettings=array(array('№','Название','Алиас','стоимость','Действие'),array("?component=product&action=Edit&table=product&edit="=>"id","?component=product&action=Edit&table=product&del="=>"id","?component=product&action=Add&table=product&add="=>"id"));

$out=$table1->format($recurse);
echo $out;

//Старая таблица
//$result=$table->makeTable('product', $check, "admin product", $actions, true);
if ($num == 0) {
    echo "Записи не добавлены";
}
?>