<?php
$begincode="<?php if (!defined(\"SIMPLE_CMS\")) die(\"Access denied\");
//if (!isset(\$_GET['id'])) header(\"Location: \" . \$GLOBALS['PATH'] . \"/404\");
set_title(\$GLOBALS['dblang_ctitle'][\$GLOBALS['userlanguage']]);
set_meta(\"\", \"\");
".$script."
render_to_template(\"components/".$_POST['alias']."/tpl/Header.php\",array('title'=>\$GLOBALS['dblang_ctitle'][\$userlanguage],'menu'=>\$GLOBALS['ssubmenu']));
";
$smenu.="'default'=>\$GLOBALS['dblang_default'][\$GLOBALS['userlanguage']],";
$Lang.="\$dblang_default=array(\"ru\"=>\"В начало\",\"en\"=>\"Begin\",);\n";
$Header="<h2><?php echo \$TEMPLATE['title'] ?></h2>
<?php echo \$TEMPLATE['menu'] ?>";
if($_POST['sitedisplay']){
	$displayall=$filecode=$begincode;
	$Lang.="\$dblang_ctitle=array(\"ru\"=>\"Заголовок\",\"en\"=>\"Title\",);\n";
for($t=1;$t<=$_POST["table"];$t++){
//<h2>".$_POST["title"]."</h2>
$filecode.="
\$res = mysql_query(\"".$SelectQueryS[$t-1]."\");
\$num = 0;
while (\$row = mysql_fetch_assoc(\$res)) {

    //\$tt=\$row[1];
";
if($_POST['multi']){

	$filecode.="\$res1=mysql_query(\"SELECT title FROM \".\$PREFIX.\"lang_text where table_name='".$_POST["tablename"][$t]."' and rel_id={\$row['id']} and language='{\$GLOBALS['userlanguage']}'\");
    while(\$row1=mysql_fetch_array(\$res1)){
        \$tt=\$row1[0];
        \$row['lang_title']=\$row1[0];
        render_to_template(\"components/".$_POST['alias']."/tpl/List.php\",\$row);
    }
    \$num++;
";
	$displayall.="\$where=(\$segments[2])?' and a.id='.intval(\$segments[2]):'';";
	$displayall.="\$res2=mysql_query(\"".$SelectQueryL[$t-1]."\$where\");
    while(\$row2=mysql_fetch_assoc(\$res2)){
        render_to_template(\"components/".$_POST['alias']."/tpl/FullList.php\",\$row2);
    }
";
	
} else {
	$filecode.="
    render_to_template(\"components/".$_POST['alias']."/tpl/List.php\",\$row);
    \$num++;
";
	$displayall.="\$where=(\$segments[2])?' where id='.intval(\$segments[2]):'';";
	$displayall.="\$res=mysql_query(\"".$SelectQueryS[$t-1]."\$where\");
    while(\$row=mysql_fetch_assoc(\$res)){
        render_to_template(\"components/".$_POST['alias']."/tpl/FullList.php\",\$row);
    }
";
}
$filecode.="
}";
//var_dump($Fields[$t]);
	foreach($_POST['langtable'][$t] as $name=>$value){
		$templatesfull.="<div class=\"".$name."\" id=\"".$name."_".$t."\"><?=\$TEMPLATE['".$name."']?></div>\n";
		$SCSS.=".".$name."_".$t."{}\r\n";
	}
	
	foreach($Fields[$t] as $num=>$name){
		$templates.="<div class=\"".$name."\" id=\"".$name."_".$t."\"><?=\$TEMPLATE['".$name."']?></div>\n";
		$SCSS.=".".$name."_".$t."{}\r\n";
	}
	
}
$FullList="<div id=\"div_<?= \$TEMPLATE['id'] ?>\" class=\"".$_POST['alias']."\">
	".$templates.$templatesfull."
	</div><br />";
    $List="<div id=\"div_<?= \$TEMPLATE['id'] ?>\" class=\"".$_POST['alias']."\">
	$templates<a href='/".$_POST['alias']."/view/<?=\$TEMPLATE['id']?>'><?=\$TEMPLATE['lang_title']?> <?=\$GLOBALS['dblang_further'][\$GLOBALS['userlanguage']]?></a>
	</div><br />";
	
	
	
	
	
	$SCSS.=".".$_POST['alias']."{}
	#div_".$row[0]."{}\r\n";
	$filecode.="if (\$num == 0) echo \$GLOBALS['dblang_norecords'][\$GLOBALS['userlanguage']];
?>";
$displayall.="?>";
	$Lang.="\$dblang_further=array(\"ru\"=>\"Далее\",\"en\"=>\"Read more\",);\n";
	$Lang.="\$dblang_norecords=array(\"ru\"=>\"Ничего не найдено\",\"en\"=>\"No records\",);\n";
	$smenu.="'view'=>\$GLOBALS['dblang_view'][\$GLOBALS['userlanguage']],";
	$Lang.="\$dblang_view=array(\"ru\"=>\"Просмотр\",\"en\"=>\"View\",);\n";	
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/actionDefault.php","w+");
	fwrite($fp,$filecode);
	fclose($fp);
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/actionView.php","w+");
	fwrite($fp,$displayall);
	fclose($fp);
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/Header.php","w+");
	fwrite($fp,$Header);
	fclose($fp);
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/List.php","w+");
	fwrite($fp,$List);
	fclose($fp);
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/FullList.php","w+");
	fwrite($fp,$FullList);
	fclose($fp);
}
if($_POST['siteadd']){
	$filecode=$begincode;
	$Forms="<?php if(\$TEMPLATE['error']): ?>
	<div class=\"error\"><?=\$TEMPLATE['error']?></div>
	<? endif?>";
	$filecode.="\$error=\"\";\n";
	for($t=1;$t<=$_POST["table"];$t++){
		$filecode.="if(\$_POST['submit']){
".$uCheck[$t-1]."
if(\$error==\"\"){
		mysql_query(\"".$Insert[$t-1]."\");
		\$rel_id=\$id=mysql_insert_id();
";
if($_POST['multi']){
		//foreach(\$GLOBALS['userlanguage'] as \$num=>\$language){
		$filecode.="\$language=\$GLOBALS['userlanguage'];
			".$CleanDB[$t-1]."
            mysql_query(\"".$MultiInsert[$t-1]."\");
            \$error=\$GLOBALS['dblang_done'][\$GLOBALS['userlanguage']];
            render_to_template(\"components/".$_POST['alias']."/tpl/Form.php\",array('error'=>\$error));
        //}
";
	}
$filecode.="
    } else {
        \$error=\$error.\$multierror;
        \$_POST['error']=\$error;
        render_to_template(\"components/".$_POST['alias']."/tpl/Form.php\",\$_POST['error']);
    }
	
} else {
    render_to_template(\"components/".$_POST['alias']."/tpl/Form.php\",array());
}

?>
";
	$Forms.=$uForm[$t-1];
}



	$Lang.="\$dblang_done=array(\"ru\"=>\"Ваше сообщение успешно отправлено\",\"en\"=>\"Your message succesfully send\",);\n";
	$smenu.="'add'=>\$GLOBALS['dblang_add'][\$GLOBALS['userlanguage']],";
	$Lang.="\$dblang_add=array(\"ru\"=>\"Добавление\",\"en\"=>\"Add\",);\n";
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/actionAdd.php","w+");
	fwrite($fp,$filecode);
	fclose($fp);
	
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/AddHeader.php","w+");
	fwrite($fp,$Header);
	fclose($fp);
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/Form.php","w+");
	fwrite($fp,$Forms);
	fclose($fp);

}
if($_POST['siteredact']){//edit
	//$header="<?php if (!defined(\"SIMPLE_CMS\")) die(\"Access denied\");";
	$filecode=$begincode;
	for($t=1;$t<=$_POST["table"];$t++){
	$filecode.="//delete data
if (isset(\$_GET['del']) && isset(\$_GET['table'])) {
    mysql_query(\"DELETE FROM \".\$PREFIX.\"\".\$_GET['table'].\" WHERE id='{\$_GET['del']}'\");
    mysql_query(\"DELETE FROM \".\$PREFIX.\"lang_text WHERE rel_id='{\$_GET['del']}' and table_name='\".\$_GET['table'].\"'\");
    //header(\"Location: ?component=static\"); 
}
//edit page
if (isset(\$_GET['edit']) && \$_GET['table']=='".$_POST["tablename"][$t]."') {
    \$res = mysql_query(\"".$SelectQuery[$t-1]." and a.id=\".\$_GET['edit']);
    if (\$row = mysql_fetch_assoc(\$res)) {
        render_to_template(\$HOSTPATH.\"/components/".$_POST['alias']."/tpl/Edit.php\",\$row);
    }
}

";
	}
	$smenu.="'edit'=>'Редактирование',";
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/actionEdit.php","w+");
	fwrite($fp,$filecode);
	fclose($fp);
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/Edit.php","w+");
	fwrite($fp,"");
	fclose($fp);
}

?>