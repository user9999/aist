<?php
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
}

/*
$table=helpFactory::activate('html/Table');
$check=array('phrase'=>'фраза','name'=>'имя', 'url'=>'ссылка');
$actions=array("/admin/?component=query&action=Edit&table=queries&edit="=>"id","/admin/?component=query&del="=>"id");
$result=$table->makeTable('queries', $check, "admin menu", $actions, true);

$queryTables=helpFactory::activate('queries/QueryTables');

//$queryTables->serialized=array('url'=>1);пытается unserialize для ru
$check=array('id','phrase','url');
$queryOut=$queryTables->makeQuery('queries',$check,true);
//print_r($queryOut);
*/

?>
<h1>Существующие записи</h1>
<?php
$res = mysql_query("select * from ".$PREFIX."queries");
$num = 0;

while ($row = mysql_fetch_array($res)) {
    $num ++;
    $string='';
    $links=unserialize($row['url']);
    foreach($links as $link=>$name){
        $string.="<a class='phrase' href='{$link}'>{$name}</a> ";
    }
    $row['url']=$string;
    $out[$row['id']]=$row;
    /*
    $tt=$row[1];
    $res1=mysql_query("SELECT title FROM ".$PREFIX."lang_text where table_name='queries' and rel_id={$row[0]} and language='{$GLOBALS[DLANG]}'");
    while($row1=mysql_fetch_row($res1)){
        $tt=$row1[0];
        break;
    }
    $num++;
    echo $tt . " (" . $row[1] . ") <a href='?component=query&action=Edit&table=queries&edit={$row[0]}'>[редактировать]</a> <a href='?component=query&action=Edit&table=queries&del={$row[0]}'>[удалить]</a><br />";
    */
     }
     render_to_template('components/query/tpl/admin.view.php', $out);
     
if ($num == 0) { echo "Записи не добавлены";
}
?>