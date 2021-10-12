<?php
if($_POST['userdisplay']){

}
if($_POST['useradd']){

}
if($_POST['userredact']){//edit
$filecode="<?php if (!defined(\"ADMIN_SIMPLE_CMS\")) die(\"Access denied\"); 
include_once 'inc/ckeditor/ckeditor.php' ;
require_once 'inc/ckfinder/ckfinder.php' ;
\$ckeditor = new CKEditor( ) ;
\$ckeditor->basePath	= 'inc/ckeditor/' ;
CKFinder::SetupCKEditor(\$ckeditor, 'inc/ckfinder/');";
	for($t=1;$t<=$_POST["table"];$t++){
	$filecode.="//delete data from ".$_POST["tablename"][$t]."
if (isset(\$_GET['del'])  && \$_GET['table']=='".$_POST["tablename"][$t]."') {
    mysql_query(\"DELETE FROM \".\$PREFIX.\"".$_POST["tablename"][$t]."\" WHERE id='{\$_GET['del']}'\");
    mysql_query(\"DELETE FROM \".\$PREFIX.\"lang_text WHERE rel_id='{\$_GET['del']}' and table_name='".$_POST["tablename"][$t]."'\");
    header(\"Location: ?component=static\"); 
}
//edit page
if (isset(\$_GET['edit']) && \$_GET['table']=='".$_POST["tablename"][$t]."') {
    \$res = mysql_query(\"".$SelectQuery[$t-1]." and a.id=\".\$_GET['edit']);
    if (\$row = mysql_fetch_assoc(\$res)) {
        render_to_template(\$HOSTPATH.\"/components/installator/tpl/user.Edit.php\",\$row);
    }

}
";
	}
	$umenu.="'Edit'=>'Редактирование',";
	$fp=fopen($HOSTPATH."/components/installator/user.actionEdit.php","w+");
	fwrite($fp,$filecode);
	fclose($fp);
	$fp=fopen($HOSTPATH."/components/installator/tpl/user.Edit.php","w+");
	fwrite($fp,"");
	fclose($fp);
}
?>