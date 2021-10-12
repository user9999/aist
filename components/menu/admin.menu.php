<?php 
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { 
    die("Access denied");
} 

$table=helpFactory::activate('html/Table');
$check=array('text'=>'название','path'=>'alias', 'ordering'=>'порядок','display'=>'отображать');
$actions=array("/admin/?component=menu&edit="=>"id","/admin/?component=menu&del="=>"id");
//$table->setType('table','admin menu');
$table->setType('flex');
$queryTables=helpFactory::activate('queries/QueryTables');
$queryOut=$queryTables->makeQuery('menu_admin',$check,true);
//print_r($queryOut);

$_SESSION['csv']=$queryOut;
$_SESSION['xml']=$queryTables->xml;
$MyTable=helpFactory::activate('queries/Visitor/TableHTML',array('admin menu',$actions));
//helpFactory::activate('queries/Visitor/TableHTML',array('admin menu',$actions));
$head="<html>
    <head>
        <title> Test </title>    
        <link rel=\"stylesheet\" href=\"http://127.0.0.2/templates/admin.blank/style.css\">
</head>
<body>";
$footer="</body></html>";
$_SESSION['pdf']=$head.$queryTables->makeOutput($MyTable).$footer;

/*
 * examples
 * получение массива (fetch_row_all)-true, по умолчанию (fetch_array) или false
 * $queryTables=helpFactory::activate('queries/QueryTables');
 * $queryOut=$queryTables->makeQuery('menu_admin',$check,true);
 * 
 * паттерн Visitor
 * получение в виде json
 * $Json=helpFactory::activate('queries/Visitor/Json');
 * echo $queryTables->makeOutput($Json);
 * 
 * получение в виде flex списка array('html_class', ссылки в get(редактирование, удаление)-$array)
 * $Flex=helpFactory::activate('queries/Visitor/FlexHTML',array('',$actions));
 * echo $queryTables->makeOutput($Flex);//echo 
 * 
 * получение в виде таблицы table
 * $MyTable=helpFactory::activate('queries/Visitor/TableHTML',array('admin menu',$actions));
 * echo $queryTables->makeOutput($MyTable);//echo 
 */


$Tab=helpFactory::activate('queries/Visitor/TableHTML',array('admin menu table table-striped responsive-utilities jambo_table bulk_action',$actions));
echo $queryTables->makeOutput($Tab);//echo 

//var_dump($queryOut);
if (isset($_GET['del'])) {
    mysql_query("DELETE FROM ".$PREFIX."menu WHERE id='{$_GET['del']}'");
    header("Location: ?component=menu"); 
}

if (isset($_GET['edit'])) {
    $res=mysql_query("SELECT * FROM ".$PREFIX."menu WHERE id='{$_GET['edit']}'");
    if ($row=mysql_fetch_row($res)) {
        $tbl_text=unserialize($row[1]);
        $tbl_path=$row[2];
        $tbl_order=$row[3];
        $editid=$row[0];
    }
}

if (isset($_POST['frm_name']) && isset($_POST['frm_path'])) {
    $frm_name=addslashes(serialize($_POST['frm_name']));
    $frm_path=$_POST['frm_path'];
    $frm_order=$_POST['frm_order'];
    $frm_parent=$_POST['frm_parent'];
    
    if($frm_parent==0) {
        $level=1;
    } else {
        $res=mysql_query("select level from ".$PREFIX."menu where id=".$frm_parent." limit 1");
        $row = mysql_fetch_row($res);
        $parent_level=$row[0];
        $level=$parent_level+1;
    }
    if (!$_POST['editid']) {
        mysql_query("INSERT INTO ".$PREFIX."menu SET text='$frm_name', path='$frm_path', ordering='$frm_order',parent=$frm_parent,level=$level");
    } else {
        //echo $frm_name;
        //die("UPDATE ".$PREFIX."menu SET text='{$frm_name}', path='$frm_path', ordering='$frm_order',parent=$frm_parent,level=$level WHERE id={$_POST['editid']}");
        mysql_query("UPDATE ".$PREFIX."menu SET text='$frm_name', path='$frm_path', ordering='$frm_order',parent=$frm_parent,level=$level WHERE id={$_POST['editid']}");
    }
    header("Location: ?component=menu");
}


$sections=array();
///1
$res = mysql_query("SELECT MAX(level) FROM ".$PREFIX."menu");
$row=mysql_fetch_row($res);
if($row[0]!==null) {//mysql_num_rows($res)>0
    //$row=mysql_fetch_row($res);
    $max=$row[0];
    //echo $max."---";
    $t="";$join=$join??'';
    for($i=1;$i<=$max;$i++){
        $t.="t$i.level AS level$i,t$i.id AS id$i,t$i.text AS text$i,t$i.path AS path$i,";
        if($i>1) {
            $join.=" LEFT JOIN ".$PREFIX."menu AS t$i ON t$i.parent = t".($i-1).".id";
        }
    }
    $t=substr($t, 0, -1);
    $query="SELECT ".$t." FROM ".$PREFIX."menu as t1".$join." where t1.parent=0";
    $res = mysql_query($query);
    //echo $query."<br>";
    //$cols=4;
    $options='';
    $ar=array();
    while($row=mysql_fetch_row($res)){
        $str="---";$val1='';
        if($row[0]==1) {
            foreach($row as $num=>$val){
        
                if($val==null) {
                    break;
                }

                if($num%4==0) {
                    $otst=str_repeat($str, $val);
                    $level=$val;
                }
                if($num%4==1) {
                    $flag=0;
                    if(!in_array($val, $ar)) {
                         $selected=($val==$tbl_parent)?"selected":"";
                         $options.="<option class=level$level value=$val $selected>";
                         $link="<a href='?component=catalog&action=1&edit=$val'>[редактировать]</a> <a href='?component=catalog&action=1&del=$val'>[удалить]</a>";
                         $ar[]=$val;
                         $flag=1;
                    }
                }
                if($num%4==2) {
                    if($flag==1) {
                        $vals=unserialize($val);
                        $n=array_shift($vals);
                        $options.=$otst.$n."</option>\n";
                        $title=mb_substr($val, 0, 40, 'UTF-8')."..";//$val;//
                    }
                }
                if($num%4==3) {
                    $val1.=$val."/";
                    if($flag==1) {

                        $valr=substr($val1, 0, -1);
                        $sections[1].="<div class=clear><div class='sec_title'>".$otst.$title. "</div> <div class='alias'>" .$val. "</div><div class='priceid'>$valr</div><div class=links>".$link."</div></div>";

                    } else {

                    }
                }

            }

        }
    }

}



?>

<h1>Меню</h1>
 
<form method="post">
    <table width="100%">
<?php
foreach($LANGUAGES as $name=>$path){

    ?>
        <tr>
            <td width="120">Пункт меню (<?php echo $name?>):</td><td><input id="name_<?php echo $name?>" class="textbox" name="frm_name[<?php echo $name?>]" type="text" size="50" value="<?php echo $tbl_text[$name]??''?>"></td>
        </tr>
    <?php
}
?>
            <td width="120">Родитель</td><td>
        <select name=frm_parent>
    <option value=0>корень</option>
    <?php echo $options; ?>
    </select>
    </td>
        </tr>
        <tr>
            <td width="120">Путь:</td><td><input class="textbox translitto" name="frm_path" type="text" size="50" value="<?php echo $tbl_path??''?>"></td>
        </tr>
        <tr>
            <td width="120">Порядок:</td><td><input class="textbox" name="frm_order" type="text" maxlength="1" size="10" value="<?php echo $tbl_order??''?>"></td>
        </tr>
        <tr>
            <td></td><td><input type='hidden' name='editid' value='<?php echo $editid??''?>'><input type="submit" class="button" value="Сохранить"></td>
        </tr>
    </table>
</form>
<br />
<br />
<h1>Существующие пункты меню</h1>
<a class="csv" href="/inc/csv.php" target="_blank">csv</a>
<a class="pdf" href="/inc/pdf.php" target="_blank">Pdf</a>
<a class="xls" href="/inc/xlsx.php" target="_blank">xlsx</a>
<a class="xml" href="/inc/xml.php" target="_blank">xml</a>
<?php
//flex
$check=array('text'=>'название','parent'=>'родитель','path'=>'alias', 'ordering'=>'порядок');
$table->serialized=array('text'=>'ru');
$result=$table->makeTable('menu',$check,"admin menu",$actions,true);
//$result=$table->makeTable('menu_admin',$check,"admin menu",$actions,true);
$res=mysql_query("SELECT * FROM ".$PREFIX."menu ORDER BY ordering, id");
$num=0;
while ($row=mysql_fetch_row($res)) {
    $num++;
    $l=unserialize($row[1]);
    //var_dump($l[$GLOBALS['DLANG']]);
    //$n=array_shift($l);
    $n=$l[$GLOBALS['DLANG']];
    //echo $n." <a href='?component=menu&edit={$row[0]}'>[редактировать]</a> <a href='?component=menu&del={$row[0]}'>[удалить]</a><br />";
}
if ($num==0) { echo "Пункты не добавлены";
}
?>
