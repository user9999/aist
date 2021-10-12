<?php if (!defined("ADMIN_SIMPLE_CMS")) die("Access denied"); 
include_once 'inc/ckeditor/ckeditor.php' ;
require_once 'inc/ckfinder/ckfinder.php' ;
$ckeditor = new CKEditor( ) ;
$ckeditor->basePath	= 'inc/ckeditor/' ;
CKFinder::SetupCKEditor($ckeditor, 'inc/ckfinder/');//delete data from test1
if (isset($_GET['del'])  && $_GET['table']=='test1') {
    mysql_query("DELETE FROM ".$PREFIX."test1" WHERE id='{$_GET['del']}'");
    mysql_query("DELETE FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['del']}' and table_name='test1'");
    header("Location: ?component=static"); 
}
//edit page
if (isset($_GET['edit']) && $_GET['table']=='test1') {
    $res = mysql_query("SELECT a.*,b.language as language,b.title,b.short,b.content,b.description,b.keywords,b.pub_date from ".$PREFIX."test1 as a,".$PREFIX."lang_text as b WHERE a.id=b.rel_id and b.table_name='test1' and a.id=".$_GET['edit']);
    if ($row = mysql_fetch_assoc($res)) {
        render_to_template($HOSTPATH."/components/installator/tpl/user.Edit.php",$row);
    }

}
//delete data from test2
if (isset($_GET['del'])  && $_GET['table']=='test2') {
    mysql_query("DELETE FROM ".$PREFIX."test2" WHERE id='{$_GET['del']}'");
    mysql_query("DELETE FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['del']}' and table_name='test2'");
    header("Location: ?component=static"); 
}
//edit page
if (isset($_GET['edit']) && $_GET['table']=='test2') {
    $res = mysql_query("SELECT a.*,b.language as language,b.title,b.short,b.content,b.description,b.keywords,b.pub_date from ".$PREFIX."test2 as a,".$PREFIX."lang_text as b WHERE a.id=b.rel_id and b.table_name='test2' and a.id=".$_GET['edit']);
    if ($row = mysql_fetch_assoc($res)) {
        render_to_template($HOSTPATH."/components/installator/tpl/user.Edit.php",$row);
    }

}
