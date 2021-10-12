<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) {
    die("Access denied");
}
    $script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>";
set_script($script);
    $error="";
//add record
if (isset($_POST['submit'])) {
    $name=mysql_real_escape_string($_POST['name']);
    //var_dump($name);
    if (!check_uniq_field('roles', 'name', $name)) {
        $error.='Такая роль уже есть в базе!';
    }
    $roles= json_encode($_POST['roles']);
    //var_dump($roles);
    //die();
    
    if ($error=="") {
        mysql_query("INSERT INTO `".$PREFIX."roles` SET name='{$name}',roles='{$roles}'");
        done("Роль добавлена");
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
    //var_dump($actions);

?>
<h1>Добавление записи</h1><form method="post">
    <label for="name"><?=$GLOBALS['dblang_name'][$DLANG]?> <input id="name" class="mainform admin_users" type=text name="name" value="<?=$tbl_name?>" required></label><br>
    <h2>Разрешения</h2>
<?php
    foreach ($actions as $component=>$action) {
        $action['component_title']=$component;
        render_to_template("components/roles/tpl/admin.Role.php", $action);
    }
?>
    
    <!--
<h1>Добавление записи</h1><form method="post"><label for="name"><?=$GLOBALS['dblang_name'][$DLANG]?> <input id="name" class="mainform admin_users" type=text name="name" value="<?=$tbl_name?>"></label><br>
<label for="login"><?=$GLOBALS['dblang_login'][$DLANG]?> <input id="login" class="mainform admin_users" type=text name="login" value="<?=$tbl_login?>" required></label><br>
<label for="password"><?=$GLOBALS['dblang_password'][$DLANG]?> <input id="password" class="mainform admin_users" type=text name="password" value="<?=$tbl_password?>" required></label><br>
<label for="phone"><?=$GLOBALS['dblang_phone'][$DLANG]?> <input id="phone" class="mainform admin_users" type=text name="phone" value="<?=$tbl_phone?>"></label><br>
<label for="email"><?=$GLOBALS['dblang_email'][$DLANG]?> <input id="email" class="mainform admin_users" type=text name="email" value="<?=$tbl_email?>"></label><br>
<label for="data"><?=$GLOBALS['dblang_data'][$DLANG]?> <input id="data" class="mainform admin_users" type=text name="data" value="<?=$tbl_data?>"></label><br>
<label for="active"><?=$GLOBALS['dblang_active'][$DLANG]?> <input id="active" class="mainform admin_users" type=text name="active" value="<?=$tbl_active?>"></label><br>
-->


<input type=submit class=button name="submit" value="Отправить">
<input type='hidden' name='editid' value='<?= $editid ?>'>
</form>
