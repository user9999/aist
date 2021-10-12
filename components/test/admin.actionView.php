<?php if (!defined("ADMIN_SIMPLE_CMS")) die("Access denied");

/*
//Вывод в таблицу рекурсивную
$recurse=helpFactory::activate('queries/QueryRecursive');
$array=$recurse->makeQuery('test','','id,mail,alias,name','ORDER BY id');//
$table1=helpFactory::activate('queries/Visitor/FormatRecursive','table');
$table1->link="/admin/?component=test";
$table1->tableSettings=array(array('id','mail','alias','name','Действие'),array("?component=test&action=Edit&table=test&edit="=>"id","?component=test&action=Edit&table=test&del="=>"id","?component=test&action=Add&table=test&add="=>"id"));
$out=$table1->format($recurse);
echo $out;
*/
//Вывод в таблицу не рекурсивное(Раскоментировать) 
$table=helpFactory::activate('html/Table');
$actions=array("/admin/?component=test&action=Edit&edit="=>"id","/admin/?component=test&del="=>"id");
$table->setType('flex');
$check=array('id'=>'№','id'=>'id','mail'=>'mail','alias'=>'alias','name'=>'name');
$result=$table->makeTable('test',$check,"admin test",$actions,true);
$check=array('id'=>'№','id'=>'id','mail'=>'mail','alias'=>'alias','name'=>'name');
            $queryTables=helpFactory::activate('queries/QueryTables');
            $queryOut=$queryTables->makeQuery('menu_admin',$check,true);
$_SESSION['csv']=$queryOut;
$_SESSION['xml']=$queryTables->xml;
$MyTable=helpFactory::activate('queries/Visitor/TableHTML',array('admin menu',$actions));
            $head="<html>
    <head>
        <title> Test </title>    
        <link rel=\'stylesheet\' href=\'/templates/admin.blank/style.css\'>
</head>
<body>";
$footer="</body></html>";
$_SESSION['pdf']=$head.$queryTables->makeOutput($MyTable).$footer;
if($_POST['xml']){
    require_once $HOSTPATH.'/inc/xml.php';
    header('Content-Type: text/xml');
    $xml=ArrayToXML::toXml($queryTables->xml, $rootNodeName = 'data', $xml=null);
    echo $xml;
    exit();
}



$res = mysql_query("select * from ".$PREFIX."test");
$num = 0;
while ($row = mysql_fetch_array($res)) {
	$tt=$row[1];
$res1=mysql_query("SELECT title FROM ".$PREFIX."lang_text where table_name='test' and rel_id={$row[0]} and language='{$GLOBALS[DLANG]}'");
	while($row1=mysql_fetch_array($res1)){
		$tt=$row1[0];
		break;
	}
	$num++;
    echo $tt . " (" . $row[1] . ") <a href='?component=test&action=Edit&table=test&edit={$row[0]}'>[редактировать]</a> <a href='?component=test&action=Edit&table=test&del={$row[0]}'>[удалить]</a><br />";
}
if ($num == 0) echo "Записи не добавлены";
?>
<form method='post'>
    <input type ='submit' name='xml' value ='xml'>
</form>
<a class="csv" href="/inc/csv.php" target="_blank">csv</a>
<a class="xml" href="/inc/xml.php" target="_blank">xml</a>
<a class="pdf" href="/inc/pdf.php" target="_blank">Pdf</a>
