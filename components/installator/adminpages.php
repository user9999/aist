<?php
if($_POST['admindisplay']){
	$aQuery=",\"INSERT INTO `\".\$PREFIX.\"menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('".$_POST['title']."', '".$_POST['alias']."', ".rand(40,140).", 1)\"";
	$filecode="<?php if (!defined(\"ADMIN_SIMPLE_CMS\")  or !check_role()) die(\"Access denied\");

?>
";
for($t=1;$t<=$_POST["table"];$t++){
    //$classFields=implode(',',$classFields);
    $classFields=array();
    foreach($Fields[$t] as $num=>$field){
        $classFields[]="'".$field."'=>'".$field."'";
        //$field=('id')?'№':$field;
        $Rfields[]=$field;
        $Nfields[]="'".$field."'";
    }
    $classFields=implode(',',$classFields);
    $Rfields=implode(',',$Rfields);
    $Nfields=implode(',',$Nfields);

    if($parentFlag){
        $classTables="
//Вывод в таблицу рекурсивную
\$recurse=helpFactory::activate('queries/QueryRecursive');
\$array=\$recurse->makeQuery('{$_POST['alias']}','{$parentField}','{$Rfields}','ORDER BY id');//
\$table1=helpFactory::activate('queries/Visitor/FormatRecursive','table');
\$table1->link=\"/admin/?component={$_POST['alias']}\";
\$table1->tableSettings=array(array({$Nfields},'Действие'),array(\"?component={$_POST['alias']}&action=Edit&table={$_POST['alias']}&edit=\"=>\"id\",\"?component={$_POST['alias']}&action=Edit&table=".$_POST['alias']."&del=\"=>\"id\",\"?component=".$_POST['alias']."&action=Add&table=".$_POST['alias']."&add=\"=>\"id\"));
\$out=\$table1->format(\$recurse);
echo \$out;
/*
Вывод в таблицу не рекурсивное(Раскоментировать) 
\$table=helpFactory::activate('html/Table');
\$actions=array(\"/admin/?component={$_POST['alias']}&action=Edit&edit=\"=>\"id\",\"/admin/?component={$_POST['alias']}&del=\"=>\"id\");
\$table->setType('flex');
\$check=array('id'=>'№',".$classFields.");
\$result=\$table->makeTable('{$_POST['alias']}',\$check,\"admin ".$_POST['alias']."\",\$actions,true);
*/";
    }else{
        $classTables="
/*
//Вывод в таблицу рекурсивную
\$recurse=helpFactory::activate('queries/QueryRecursive');
\$array=\$recurse->makeQuery('{$_POST['alias']}','{$parentField}','{$Rfields}','ORDER BY id');//
\$table1=helpFactory::activate('queries/Visitor/FormatRecursive','table');
\$table1->link=\"/admin/?component={$_POST['alias']}\";
\$table1->tableSettings=array(array({$Nfields},'Действие'),array(\"?component={$_POST['alias']}&action=Edit&table={$_POST['alias']}&edit=\"=>\"id\",\"?component={$_POST['alias']}&action=Edit&table=".$_POST['alias']."&del=\"=>\"id\",\"?component=".$_POST['alias']."&action=Add&table=".$_POST['alias']."&add=\"=>\"id\"));
\$out=\$table1->format(\$recurse);
echo \$out;
*/
//Вывод в таблицу не рекурсивное(Раскоментировать) 
\$table=helpFactory::activate('html/Table');
\$actions=array(\"/admin/?component={$_POST['alias']}&action=Edit&edit=\"=>\"id\",\"/admin/?component={$_POST['alias']}&del=\"=>\"id\");
\$table->setType('flex');
\$check=array('id'=>'№',".$classFields.");
\$result=\$table->makeTable('{$_POST['alias']}',\$check,\"admin {$_POST['alias']}\",\$actions,true);
";
}
$format_out="";
if($_POST['csv'] || $_POST['xml'] || $_POST['xls'] || $_POST['json'] || $_POST['pdf']){
    $classTables.="\$check=array('id'=>'№',".$classFields.");
            \$queryTables=helpFactory::activate('queries/QueryTables');
            \$queryOut=\$queryTables->makeQuery('menu_admin',\$check,true);\n";
    if($_POST['csv']){
        $format_out.="<a class=\"csv\" href=\"/inc/csv.php\" target=\"_blank\">csv</a>\n";
        $classTables.="\$_SESSION['csv']=\$queryOut;\n";
    }
    if($_POST['xml']){
        $format_out.="<a class=\"xml\" href=\"/inc/xml.php\" target=\"_blank\">xml</a>\n";
        $classTables.="\$_SESSION['xml']=\$queryTables->xml;\n";
    }
    if($_POST['pdf']){
        $format_out.="<a class=\"pdf\" href=\"/inc/pdf.php\" target=\"_blank\">Pdf</a>\n";
        $classTables.="\$MyTable=helpFactory::activate('queries/Visitor/TableHTML',array('admin menu',\$actions));
            \$head=\"<html>
    <head>
        <title> Test </title>    
        <link rel=\'stylesheet\' href=\'/templates/admin.blank/style.css\'>
</head>
<body>\";
\$footer=\"</body></html>\";
\$_SESSION['pdf']=\$head.\$queryTables->makeOutput(\$MyTable).\$footer;\n";
    }
    if($_POST['xls']){
        $format_out.="<a class=\"xls\" href=\"/inc/xlsx.php\" target=\"_blank\">xlsx</a>\n";
        $classTables.="";
    }
    if($_POST['json']){
        $classTables.="";
    }
}

$filecode.="<h1>Существующие записи</h1>
<?php
".$classTables."
\$res = mysql_query(\"".$SelectQueryS[$t-1]."\");
\$num = 0;
while (\$row = mysql_fetch_array(\$res)) {
	\$tt=\$row[1];
";
if($_POST['multi']){
	if($source_table=='lang_text'){	
		$filecode.="\$res1=mysql_query(\"SELECT title FROM \".\$PREFIX.\"lang_text where table_name='".$_POST["tablename"][$t]."' and rel_id={\$row[0]} and language='{\$GLOBALS[DLANG]}'\");
	while(\$row1=mysql_fetch_array(\$res1)){
		\$tt=\$row1[0];
		break;
	}
	";
	} else {
		$filecode.="\$res1=mysql_query(\"SELECT * FROM \".\$PREFIX.\"$source_table rel_id={\$row[0]}\");
	while(\$row1=mysql_fetch_array(\$res1)){
		\$tt=\$row1[1];
		break;
	}
	";
	}
}
    $filecode.="\$num++;
    echo \$tt . \" (\" . \$row[1] . \") <a href='?component=".$_POST['alias']."&action=Edit&table=".$_POST["tablename"][$t]."&edit={\$row[0]}'>[редактировать]</a> <a href='?component=".$_POST['alias']."&action=Edit&table=".$_POST["tablename"][$t]."&del={\$row[0]}'>[удалить]</a><br />\";
}
if (\$num == 0) echo \"Записи не добавлены\";
?>\n".$format_out;
}
	$menu.="'View'=>'Просмотр',";
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/admin.actionView.php","w+");
	fwrite($fp,$filecode);
	fclose($fp);
}
if($_POST['adminadd']){
    if($_POST["csv"] || $_POST["json"] || $_POST["xml"] || $_POST["pdf"] || $_POST["xls"]){
        $check_chpu_url="
        foreach(\$_POST['type'] as \$name=>\$value){
            \$error.=(chpu_check(\$url)=='exists')?\"url {\$url} уже есть в базе\":'';
        }
        ";
        $url_queries="
            foreach(\$_POST['type'] as \$name=>\$value){
                \$type=str_replace(\"url_\",\"\",\$name);
                \$url= mysql_real_escape_string(\$_POST[\$name]);
                \$query=\"INSERT INTO \".\$PREFIX.\"url SET url='{\$url}',component='test',cmsurl='test/{\$rel_id}',type='{\$type}'\";
                mysql_query(\$query);
            }
                ";
    }else{
        $check_chpu_url="
            \$error.=(chpu_check(\$url)=='exists')?'Такой url уже есть в базе':'';
            ";
        $url_queries="
            \$query=\"INSERT INTO \".\$PREFIX.\"url SET url='{\$url}',component='{$_POST['alias']}',cmsurl='{$_POST['alias']}/{\$rel_id}'\";
            mysql_query(\$query);
            ";
    }
	$aQuery=",\"INSERT INTO `\".\$PREFIX.\"menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('".$_POST['title']."', '".$_POST['alias']."', ".rand(40,140).", 1)\"";
	$filecode="<?php if (!defined(\"ADMIN_SIMPLE_CMS\")) die(\"Access denied\"); 
	".$script."
	\$error=\"\";";

for($t=1;$t<=$_POST["table"];$t++){
	$filecode.="
//add record
if (isset(\$_POST['submit'])) {
    ".$Check[$t-1]."
    \$url=mysql_real_escape_string(\$_POST['url']);
    if(\$MY_URL==1 && strlen(\$url)>0){
        ".$check_chpu_url."
    }
    if(\$error==\"\"){
        mysql_query(\"".$Insert[$t-1]."\");
        \$rel_id=\$id=mysql_insert_id();
        if(\$MY_URL==1 && strlen(\$url)>0){
            ".$url_queries."
        }
        foreach(\$_POST['stufflang'] as \$num=>\$language){
			".$CleanDB[$t-1]."
            mysql_query(\"".$MultiInsert[$t-1]."\");
        }
    } else {
        error(\$error.\$multierror);
    }
}
?>
<h1>Добавление записи</h1>".$Form[$t-1]."
<input type='hidden' name='editid' value='<?= \$editid ?>'>
</form>
";
}
	$menu.="'Add'=>'Добавление',";
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/admin.actionAdd.php","w+");
	fwrite($fp,$filecode);
	fclose($fp);
	//$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/admin.Add.php","w+");
	//fwrite($fp,"");
	//fclose($fp);
}
if($_POST['adminredact']){//edit
	$aQuery=",\"INSERT INTO `\".\$PREFIX.\"menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('".$_POST['title']."', '".$_POST['alias']."', ".rand(40,140).", 1)\"";
//var_dump($_POST["tablename"]);
	$filecode="<?php if (!defined(\"ADMIN_SIMPLE_CMS\")) die(\"Access denied\");
	".$script."
";
for($t=1;$t<=$_POST["table"];$t++){
	$filecode.="//delete data
if (isset(\$_GET['del']) && isset(\$_GET['table'])) {
    mysql_query(\"DELETE FROM \".\$PREFIX.\"\".\$_GET['table'].\" WHERE id='{\$_GET['del']}'\");\r\n";

if($source_table=='lang_text'){	
	$filecode.="    mysql_query(\"DELETE FROM \".\$PREFIX.\"lang_text WHERE rel_id='{\$_GET['del']}' and table_name='\".\$_GET['table'].\"'\");\r\n";
} else {
	$filecode.="    mysql_query(\"DELETE FROM \".\$PREFIX.\"$source_table WHERE rel_id='{\$_GET['del']}'\");\r\n";
}	
    $filecode.="    header(\"Location: ?component={$_POST['alias']}\"); 
}
//edit page
if (isset(\$_GET['edit']) && \$_GET['table']=='".$_POST["tablename"][$t]."') {
    \$res = mysql_query(\"".$SelectQueryS[$t-1]." WHERE id=\".\$_GET['edit']);
	
    if (\$row = mysql_fetch_assoc(\$res)) {
        foreach(\$row as \$name=>\$value){
            \$n=\"tbl_\".\$name;
            \${\$n} = \$value;
        }
        \$editid = \$row['id'];\r\n";
		if($_POST['multi']){		
			$filecode.="\$res1 = mysql_query(\"".$SelectQueryLT[$t-1]."\");

        while(\$row1=mysql_fetch_assoc(\$res1)){
            foreach(\$row1 as \$name=>\$value){
                \$n=\"tbl_\".\$name;
                \${\$n}[\$row1['language']] = \$value;
            }
        }
        if(\$MY_URL==1){
            \$query=\"SELECT * FROM \".\$PREFIX.\"url WHERE cmsurl='".$_POST['alias']."/{\$_GET['edit']}' LIMIT 1\";
            \$result=mysql_query(\$query);
            \$urlrow= mysql_fetch_array(\$result);
            \$url=\$urlrow['url'];
            
        }
";
		}
    $filecode.="	}
}
if (isset(\$_POST['submit'])) {
	\$rel_id=\$id=intval(\$_POST['editid']);
	\$error=\"\";
        if(\$MY_URL==1){
            \$url=mysql_real_escape_string(\$_POST['url']);
        }
	".$Check[$t-1]."
        if(\$MY_URL==1){
            \$frm_url=mysql_real_escape_string(\$_POST['url']);
            if(chpu_check(\$frm_url,'".$_POST['alias']."/'.\$_POST['editid'])=='exists'){
                \$error.='Введённый ЧПУ -\"'.\$alias.'\" уже есть в базе<br />';
            }
        }
	if(\$error==\"\"){
            mysql_query(\"".$Update[$t-1]."\");
            if(\$MY_URL==1){
                if(chpu_check(\$frm_url,'".$_POST['alias']."/'.\$_POST['editid'])=='update'){
                    \$query=\"UPDATE \".\$PREFIX.\"url SET url='{\$url}' WHERE cmsurl='".$_POST['alias']."/{\$_POST['editid']}'\";
                }else{
                    \$query=\"INSERT INTO \".\$PREFIX.\"url SET url='{\$url}',component='static',cmsurl='".$_POST['alias']."/{\$_POST['editid']}'\";
                }
            }";
		if($_POST['multi']){
$filecode.="        foreach(\$_POST['stufflang'] as \$num=>\$language){
				".$CleanDB[$t-1]."
                \$res=mysql_query(\"select id from \".\$PREFIX.\"lang_text where rel_id={\$rel_id} and table_name='".$_POST["tablename"][$t]."' and language='{\$language}'\");
                if(mysql_num_rows(\$res)>0){
                    mysql_query(\"".$MultiUpdate[$t-1]."\");
                } else {
                    mysql_query(\"".$MultiInsert[$t-1]."\");
                }
            }
";
		}
$filecode.="	} else {
        error(\$error.\$multierror);
    }
}
?>
<h1>Редактирование</h1>".$Form[$t-1]."
<input type='hidden' name='editid' value='<?= \$editid ?>'>
</form>
";

}
	$menu.="'Edit'=>'Редактирование',";
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/admin.actionEdit.php","w+");
	fwrite($fp,$filecode);
	fclose($fp);
}
?>