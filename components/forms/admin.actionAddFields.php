<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) {
    die("Access denied");
}
$tpl=array();
if (isset($_GET['formid'])) {
    $query="select * from ".$PREFIX."forms WHERE id=".$_GET['formid'];
    $res = mysql_query($query);
    $row= mysql_fetch_array($res);
    $tpl['form']=$row;
    $tpl['form_id']=$row['id'];
    //echo $query;
    if ($row['tablename']!='') {
        $query="SHOW TABLES LIKE '".$PREFIX."{$row['tablename']}'";
        $res = mysql_query($query);
        if (mysql_num_rows($res)>0) {
            $query1="SELECT * FROM `".$PREFIX."form_inputs` WHERE form_id={$tpl['form_id']} ORDER BY POSITION";
            //echo $query1;
            $result1=mysql_query($query1);
            
            if(mysql_num_rows($result1)>0){
                while($row1= mysql_fetch_array($result1)){
                    $tpl['table_fields'][]=$row1;
                }
            }else{
               
                $query="SHOW COLUMNS FROM `".$PREFIX."{$row['tablename']}`";
                $res = mysql_query($query);
                $tpl['table_fields']=array();
                while ($row= mysql_fetch_array($res)) {
                    if ($row['Field']!='id') {
                        $tpl['table_fields'][]['name']=$row['Field'];
                    }
                    $tpl['selectfield'].="<option value='{$row['Field']}'>{$row['Field']}</option>";
                }
            }
            
        }
    }else{
        $query1="SELECT * FROM `".$PREFIX."form_inputs` WHERE form_id={$tpl['form_id']} ORDER BY POSITION";
            //echo $query1;
            $result1=mysql_query($query1);
            
            if(mysql_num_rows($result1)>0){
                while($row1= mysql_fetch_array($result1)){
                    $tpl['table_fields'][]=$row1;
                }
            }
    }
    //print_r($tpl['table_fields']);
    /*
    if ($row = mysql_fetch_assoc($res)) {
        foreach($row as $name=>$value){
            $n="tbl_".$name;
            ${$n} = $value;
        }
        $editid = $row['id'];
    }
     * */
}
if(isset($_POST['price'])){
    submitForm(2);
}
if (isset($_POST['submit'])) {
    $i=0;
    $form_id=($_POST['form_id'])?intval($_POST['form_id']):intval($_GET['formid']);
    $query="DELETE FROM `".$PREFIX."form_inputs` WHERE form_id={$form_id}";
    mysql_query($query);
    unset($tpl['table_fields']);
    $tpl['table_fields']=array();
    
    $query=array();
    foreach ($_POST['text'] as $text) {
        if ($_POST['name'][$i]=='' && $_POST['text'][$i]=='' && $_POST['position'][$i]=='' && $_POST['value'][$i]=='') {
            
        }else{
            //echo $i;
            $tpl['table_fields'][$i]['text']=$text=mysql_real_escape_string($_POST['text'][$i]);
            $tpl['table_fields'][$i]['type']=$type=(strlen($_POST['type'][$i])>3)?mysql_real_escape_string($_POST['type'][$i]):$error.=$GLOBALS['dblang_ErType2'][$DLANG];
            $tpl['table_fields'][$i]['name']=$name=(strlen($_POST['name'][$i])>3)?mysql_real_escape_string($_POST['name'][$i]):$error.=$GLOBALS['dblang_ErName2'][$DLANG];
            $tpl['table_fields'][$i]['attributes']=$attributes=($_POST['attributes'][$i])?mysql_real_escape_string($_POST['attributes'][$i]):"";
            $tpl['table_fields'][$i]['placeholder']=$placeholder=($_POST['placeholder'][$i])?mysql_real_escape_string($_POST['placeholder'][$i]):"";
            $tpl['table_fields'][$i]['value=']=$value=($_POST['value'][$i])?mysql_real_escape_string($_POST['value'][$i]):"";
            $tpl['table_fields'][$i]['required']=$required=($_POST['required'][$i])?mysql_real_escape_string($_POST['required'][$i]):"";
            $tpl['table_fields'][$i]['check_function']=$check_function=($_POST['check_function'][$i])?mysql_real_escape_string($_POST['check_function'][$i]):"";
            $tpl['table_fields'][$i]['make_function']=$make_function=($_POST['make_function'][$i])?mysql_real_escape_string($_POST['make_function'][$i]):"";
            $tpl['table_fields'][$i]['position']=$position=intval($_POST['position'][$i]);
            $query[]="INSERT INTO `".$PREFIX."form_inputs` SET form_id='{$form_id}',text='{$text}',type='{$type}',name='{$name}',attributes='{$attributes}',placeholder='{$placeholder}',value='{$value}',required='{$required}',check_function='{$check_function}',make_function='{$make_function}',position='{$position}'";
        }
        //echo $error;
        $i++;
    }
    //print_r($tpl['table_fields']);
    //print_r($query);die();
    $rel_id=$id=intval($_POST['editid']);
    
    
    if ($error=="") {
        foreach ($query as $q) {
            mysql_query($q);
        }
        //mysql_query("UPDATE `".$PREFIX."form_inputs` SET form_id='{$form_id}',text='{$text}',type='{$type}',name='{$name}',attributes='{$attributes}',placeholder='{$placeholder}',value='{$value}',required='{$required}',check_function='{$check_function}',make_function='{$make_function}',position='{$position}' WHERE id=$id");
    } else {
        echo $error.$multierror;
    }
}
render_to_template("components/forms/tpl/admin.formFields.php", $tpl);
