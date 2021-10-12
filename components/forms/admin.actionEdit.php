<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) {
    die("Access denied");
}
  
//delete data
if (isset($_GET['del']) && isset($_GET['table'])) {
    mysql_query("DELETE FROM ".$PREFIX."".$_GET['table']." WHERE id='{$_GET['del']}'");
    mysql_query("DELETE FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['del']}' and table_name='".$_GET['table']."'");
    header("Location: ?component=forms");
}
//edit page
if (isset($_GET['edit'])) {
    $res = mysql_query("select * from ".$PREFIX."forms WHERE id=".$_GET['edit']);
    
    if ($row = mysql_fetch_assoc($res)) {
        foreach ($row as $pname=>$value) {
            $n="tbl_".$pname;
            ${$n} = $value;
            $tpl[$n]= $value;
        }
        $tpl['editid'] = $row['id'];
    }
}
if (isset($_POST['submit'])) {
    $rel_id=$id=intval($_POST['editid']);
    $error="";
    $name=(strlen($_POST['name'])>3)?mysql_real_escape_string($_POST['name']):$error.=$GLOBALS['dblang_ErName1'][$DLANG];
    $tablename=mysql_real_escape_string($_POST['tablename']);
    $alias=(strlen($_POST['alias'])>3)?mysql_real_escape_string($_POST['alias']):$error.=$GLOBALS['dblang_ErAlias1'][$DLANG];
    $enctype=mysql_real_escape_string($_POST['enctype']);
    $method=(strlen($_POST['method'])>3)?mysql_real_escape_string($_POST['method']):"post";
    $action=mysql_real_escape_string($_POST['action']);
    $attributes=mysql_real_escape_string($_POST['attributes']);
    $html=mysql_real_escape_string($_POST['html']);
    foreach ($_POST as $pname=>$value) {
        $n="tbl_".$pname;
        ${$n} = $value;
        $tpl[$n]= $value;
    }
    if ($error=="") {
        $query="UPDATE `".$PREFIX."forms` SET name='{$name}',tablename='{$tablename}',alias='{$alias}',enctype='{$enctype}',method='{$method}',action='{$action}',attributes='{$attributes}',html='{$html}' WHERE id=$id";

        mysql_query($query);
    } else {
        echo $error.$multierror;
    }
}
//print_r($tpl);
render_to_template("components/forms/tpl/admin.Forms.php", $tpl);
?>
<!--
//delete data
if (isset($_GET['del']) && isset($_GET['table'])) {
    mysql_query("DELETE FROM ".$PREFIX."".$_GET['table']." WHERE id='{$_GET['del']}'");
    mysql_query("DELETE FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['del']}' and table_name='".$_GET['table']."'");
    header("Location: ?component=forms"); 
}
//edit page
if (isset($_GET['edit']) && $_GET['table']=='form_inputs') {
    $res = mysql_query("select * from ".$PREFIX."form_inputs WHERE id=".$_GET['edit']);
	
    if ($row = mysql_fetch_assoc($res)) {
        foreach($row as $name=>$value){
            $n="tbl_".$name;
            ${$n} = $value;
        }
        $editid = $row['id'];
	}
}
if (isset($_POST['submit'])) {
	$rel_id=$id=intval($_POST['editid']);
	$error="";
	$form_id=(strlen($_POST['form_id'])>3)?mysql_real_escape_string($_POST['form_id']):$error.=$GLOBALS['dblang_ErForm_id2'][$DLANG];
$text=(strlen($_POST['text'])>3)?mysql_real_escape_string($_POST['text']):$error.=$GLOBALS['dblang_ErText2'][$DLANG];
$type=(strlen($_POST['type'])>3)?mysql_real_escape_string($_POST['type']):$error.=$GLOBALS['dblang_ErType2'][$DLANG];
$name=(strlen($_POST['name'])>3)?mysql_real_escape_string($_POST['name']):$error.=$GLOBALS['dblang_ErName2'][$DLANG];
$attributes=(strlen($_POST['attributes'])>3)?mysql_real_escape_string($_POST['attributes']):$error.=$GLOBALS['dblang_ErAttributes2'][$DLANG];
$placeholder=(strlen($_POST['placeholder'])>3)?mysql_real_escape_string($_POST['placeholder']):$error.=$GLOBALS['dblang_ErPlaceholder2'][$DLANG];
$value=(strlen($_POST['value'])>3)?mysql_real_escape_string($_POST['value']):$error.=$GLOBALS['dblang_ErValue2'][$DLANG];
$required=(strlen($_POST['required'])>3)?mysql_real_escape_string($_POST['required']):$error.=$GLOBALS['dblang_ErRequired2'][$DLANG];
$check_function=(strlen($_POST['check_function'])>3)?mysql_real_escape_string($_POST['check_function']):$error.=$GLOBALS['dblang_ErCheck_function2'][$DLANG];
$make_function=(strlen($_POST['make_function'])>3)?mysql_real_escape_string($_POST['make_function']):$error.=$GLOBALS['dblang_ErMake_function2'][$DLANG];

	if($error==""){
		mysql_query("UPDATE `".$PREFIX."form_inputs` SET form_id='{$form_id}',text='{$text}',type='{$type}',name='{$name}',attributes='{$attributes}',placeholder='{$placeholder}',value='{$value}',required='{$required}',check_function='{$check_function}',make_function='{$make_function}' WHERE id=$id");	} else {
        echo $error.$multierror;
    }
}
?>-->

