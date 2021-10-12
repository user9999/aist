<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) {
    die("Access denied");
}
    $script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>";
set_script($script);
//delete data

//edit page
if (isset($_GET['edit'])) {
    $res = mysql_query("select * from ".$PREFIX."roles WHERE id=".$_GET['edit']);
    
    if ($row = mysql_fetch_assoc($res)) {
        foreach ($row as $name=>$value) {
            $n="tbl_".$name;
            if ($name=='roles') {
                ${$n} = json_decode($value);
            } else {
                ${$n} = $value;
            }
        }
        $editid = $row['id'];
    }
}
if (isset($_POST['submit'])) {
    $rel_id=$id=intval($_POST['editid']);
    $error="";
    $name=mysql_real_escape_string($_POST['name']);
    $roles= json_encode($_POST['roles']);
    if ($error=="") {
        $query="UPDATE `".$PREFIX."roles` SET name='{$name}', roles='{$roles}' WHERE id=$id";
        mysql_query($query);
        done("Запись изменена");
    } else {
        error($error.$multierror);
    }
}

    $actions=array();
    $query="SELECT * FROM ".$PREFIX."installed";
    $result=mysql_query($query);
    while ($row=mysql_fetch_array($result)) {
        foreach (glob($HOSTPATH."/components/{$row['name']}/install.php") as $file) {
            require_once($file);
            //echo $file."<hr>";
            $actname="install".ucfirst($row['name']);
            //var_dump($$actname['submenu']);
            
            $actions[$row['name']]=$$actname['submenu'];
            if (!$$actname['submenu']) {
                $actions[$row['name']]['Default']='Редактирование';
            }
            if ($$actname['submenu']['View']) {
                $actions[$row['name']]['Delete']='Удаление';
            }
            //unset($installRoles);
        }
            
        

        //echo $row['name']."<br>";
    }

?>
<h1>Редактирование</h1><form method="post"><label for="name"><?=$GLOBALS['dblang_name'][$DLANG]?> <input id="name" class="mainform admin_users" type=text name="name" value="<?=$tbl_name?>" readonly></label><br>

<?php
    foreach ($actions as $component=>$action) {
        $action['component_title']=$component;
        $action['checked']=$tbl_roles;
        render_to_template("components/roles/tpl/admin.Role.php", $action);
    }
?>

<input type=submit class=button name="submit" value="Отправить">
<input type='hidden' name='editid' value='<?= $editid ?>'>
</form>
