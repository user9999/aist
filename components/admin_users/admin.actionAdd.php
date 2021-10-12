<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) die("Access denied"); 
	$script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>";
set_script($script);
	$error="";
//add record
if (isset($_POST['submit'])) {
    $name=mysql_real_escape_string($_POST['name']);
    $login=(strlen($_POST['login'])>3)?mysql_real_escape_string($_POST['login']):$error.=$GLOBALS['dblang_ErLogin1'][$DLANG];
    $password=(strlen($_POST['password'])>3)?mysql_real_escape_string($_POST['password']):$error.=$GLOBALS['dblang_ErPassword1'][$DLANG];
    $phone=mysql_real_escape_string($_POST['phone']);
    $email=mysql_real_escape_string($_POST['email']);
    $data=mysql_real_escape_string($_POST['data']);
    $role=intval($_POST['role']);
    //$reg_date=(strlen($_POST['reg_date'])>3)?mysql_real_escape_string($_POST['reg_date']):$error.=$GLOBALS['dblang_ErReg_date1'][$DLANG];
    $reg_date= date("Y-m-d H:i:s",time());
    $active=intval($_POST['active']);
    if(!check_uniq_field('admin_users','login',$login)){
        $error.='Такой логин уже есть в базе!';
    }
    if($error==""){
        $password=encrypt($password,$SECRET_KEY);
        mysql_query("INSERT INTO `".$PREFIX."admin_users` SET name='{$name}',login='{$login}',password='{$password}',phone='{$phone}',email='{$email}',data='{$data}',reg_date='{$reg_date}',role='{$role}', active='{$active}'");
        done("Запись добавлена");
        $tbl_password=decrypt($password,$SECRET_KEY);
    } else {
        error($error.$multierror);
    }
    
}
$query="SELECT id,name FROM ".$PREFIX."roles";
$result=mysql_query($query);
$select_role="<select name='role'>";
while($row = mysql_fetch_array($result)){
    $selected=($tbl_role==$row['id'])?'selected':'';
    $select_role.="<option value='{$row['id']}' {$selected}>{$row['name']}</option>";
}
$select_role.="</select>";
?>
<h1>Добавление записи</h1><form method="post"><label for="name"><?=$GLOBALS['dblang_name'][$DLANG]?> <input id="name" class="mainform admin_users" type=text name="name" value="<?=$tbl_name?>"></label><br>
<label for="login"><?=$GLOBALS['dblang_login'][$DLANG]?> <input id="login" class="mainform admin_users" type=text name="login" value="<?=$tbl_login?>" required></label><br>
<label for="password"><?=$GLOBALS['dblang_password'][$DLANG]?> <input id="password" class="mainform admin_users" type=text name="password" value="<?=$tbl_password?>" required></label><br>
<label for="phone"><?=$GLOBALS['dblang_phone'][$DLANG]?> <input id="phone" class="mainform admin_users" type=text name="phone" value="<?=$tbl_phone?>"></label><br>
<label for="email"><?=$GLOBALS['dblang_email'][$DLANG]?> <input id="email" class="mainform admin_users" type=text name="email" value="<?=$tbl_email?>"></label><br>
<label for="data"><?=$GLOBALS['dblang_data'][$DLANG]?> <input id="data" class="mainform admin_users" type=text name="data" value="<?=$tbl_data?>"></label><br>
<label for='role'><?=$GLOBALS['dblang_role'][$DLANG]?> <?=$select_role?></label><br>
<label for="active"><?=$GLOBALS['dblang_active'][$DLANG]?> <input id="active" class="mainform admin_users" type=number name="active" min=0 max=1 value="<?=$tbl_active?>"></label><br>



<input type=submit class=button name="submit" value="Отправить">
<input type='hidden' name='editid' value='<?= $editid ?>'>
</form>
