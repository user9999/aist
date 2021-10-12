<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) {
    die("Access denied");
}
    
    $error="";
//add record
$tpl=array();
if (isset($_POST['submit'])) {
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
    //var_dump($tpl);die();
    if ($error=="") {
        $query="INSERT INTO `".$PREFIX."forms` SET name='{$name}',tablename='{$tablename}',alias='{$alias}',enctype='{$enctype}',method='{$method}',action='{$action}',attributes='{$attributes}',html='{$html}'";
        //echo $query;die();
        mysql_query($query);
        $tpl['editid']=$rel_id=$id=mysql_insert_id();
    } else {
        echo $error.$multierror;
    }
}
$table_options="";
$query="SHOW TABLES";
$result=mysql_query($query);
while ($row= mysql_fetch_array($result)) {
    if (strpos($row[0], $PREFIX)!==false) {
        $table=str_replace($PREFIX, "", $row[0]);
        $table_options.="<option value=\"{$table}\">\r\n";
    }
}
$tpl['table_names']=$table_options;
render_to_template("components/forms/tpl/admin.Forms.php", $tpl);
?>


//add record
if (isset($_POST['submit'])) {
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
        mysql_query("INSERT INTO `".$PREFIX."form_inputs` SET form_id='{$form_id}',text='{$text}',type='{$type}',name='{$name}',attributes='{$attributes}',placeholder='{$placeholder}',value='{$value}',required='{$required}',check_function='{$check_function}',make_function='{$make_function}'");
        $rel_id=$id=mysql_insert_id();
        foreach($_POST['stufflang'] as $num=>$language){
			
            mysql_query("INSERT INTO `".$PREFIX."lang_text` SET rel_id={$rel_id} ,table_name='form_inputs',language='{$language}',");
        }
    } else {
        echo $error.$multierror;
    }
}
?>
<h1>Добавление записи</h1><form method="post">
    <label for="form_id"><?=$GLOBALS['dblang_form_id'][$DLANG]?> <input id="form_id" class="forms" type=text name="form_id" value="<?=$tbl_form_id?>"></label><br>
    <label for="text"><?=$GLOBALS['dblang_text'][$DLANG]?> <input id="text" class="forms" type=text  name="text" value="<?=$tbl_text?>"></label><br>
    <label for="type"><?=$GLOBALS['dblang_type'][$DLANG]?> <input id="type" class="forms" type=text name="type" value="<?=$tbl_type?>"></label><br>
    <label for="name"><?=$GLOBALS['dblang_name'][$DLANG]?> <input id="name" class="forms" type=text name="name" value="<?=$tbl_name?>"></label><br>
    <label for="attributes"><?=$GLOBALS['dblang_attributes'][$DLANG]?> <input id="attributes" class="forms" type=text name="attributes" value="<?=$tbl_attributes?>"></label><br>
    <label for="placeholder"><?=$GLOBALS['dblang_placeholder'][$DLANG]?> <input id="placeholder" class="forms" type=text name="placeholder" value="<?=$tbl_placeholder?>"></label><br>
    <label for="value"><?=$GLOBALS['dblang_value'][$DLANG]?> <input id="value" class="forms" type=text name="value" value="<?=$tbl_value?>"></label><br>
    <label for="required"><?=$GLOBALS['dblang_required'][$DLANG]?> <input id="required" class="forms" type=text name="required" value="<?=$tbl_required?>"></label><br>
    <label for="check_function"><?=$GLOBALS['dblang_check_function'][$DLANG]?> <input id="check_function" class="forms" type=text name="check_function" value="<?=$tbl_check_function?>"></label><br>
    <label for="make_function"><?=$GLOBALS['dblang_make_function'][$DLANG]?> <input id="make_function" class="forms" type=text name="make_function" value="<?=$tbl_make_function?>"></label><br>
<input type=submit name="submit" value="Отправить">
<input type='hidden' name='editid' value='<?= $editid ?>'>
</form>
