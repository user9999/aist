<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) die("Access denied");
	$script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>";
set_script($script);
//edit page
if (isset($_GET['details'])) {
    $res = mysql_query("select * from ".$PREFIX."messages WHERE id=".$_GET['details']);
	
    if ($row = mysql_fetch_assoc($res)) {
        foreach($row as $name=>$value){
            $n="tbl_".$name;
            ${$n} = $value;
        }
        $editid = $row['id'];
	}
        mysql_query("UPDATE ".$PREFIX."messages SET status=1 WHERE id='{$_GET['details']}'");
}
if (isset($_POST['submit'])) {
	$rel_id=$id=intval($_POST['editid']);
	$error="";
	$name=(strlen($_POST['name'])>3)?mysql_real_escape_string($_POST['name']):$error.=$GLOBALS['dblang_ErName1'][$DLANG];
    $phone=(strlen($_POST['phone'])>3)?mysql_real_escape_string($_POST['phone']):$error.=$GLOBALS['dblang_ErPhone1'][$DLANG];
    $email=(strlen($_POST['email'])>3)?mysql_real_escape_string($_POST['email']):$error.=$GLOBALS['dblang_ErEmail1'][$DLANG];
    $theme=(strlen($_POST['theme'])>3)?mysql_real_escape_string($_POST['theme']):$error.=$GLOBALS['dblang_ErTheme1'][$DLANG];
    $message=(strlen($_POST['message'])>3)?mysql_real_escape_string($_POST['message']):$error.=$GLOBALS['dblang_ErMessage1'][$DLANG];
    $file=(strlen($_POST['file'])>3)?mysql_real_escape_string($_POST['file']):$error.=$GLOBALS['dblang_ErFile1'][$DLANG];
    $type=(strlen($_POST['type'])>3)?mysql_real_escape_string($_POST['type']):$error.=$GLOBALS['dblang_ErType1'][$DLANG];
    $from_url=(strlen($_POST['from_url'])>3)?mysql_real_escape_string($_POST['from_url']):$error.=$GLOBALS['dblang_ErFrom_url1'][$DLANG];
    $date=(strlen($_POST['date'])>3)?mysql_real_escape_string($_POST['date']):$error.=$GLOBALS['dblang_ErDate1'][$DLANG];

	if($error==""){
		mysql_query("UPDATE `".$PREFIX."messages` SET name='{$name}',phone='{$phone}',email='{$email}',theme='{$theme}',message='{$message}',file='{$file}',type='{$type}',from_url='{$from_url}',date='{$date}' WHERE id=$id");	} else {
        echo $error.$multierror;
    }
}
?>
<h1>Редактирование</h1><form method="post">
    <label for="name"><?=$GLOBALS['dblang_name'][$DLANG]?> <input id="name" class="messages" type=text name="name" value="<?=$tbl_name?>" readonly></label><br>
    <label for="phone"><?=$GLOBALS['dblang_phone'][$DLANG]?> <input id="phone" class="messages" type=text name="phone" value="<?=$tbl_phone?>" readonly></label><br>
    <label for="email"><?=$GLOBALS['dblang_email'][$DLANG]?> <input id="email" class="messages" type=text name="email" value="<?=$tbl_email?>" readonly></label><br>
    <label for="theme"><?=$GLOBALS['dblang_theme'][$DLANG]?> <input id="theme" class="messages" type=text name="theme" value="<?=$tbl_theme?>" readonly></label><br>
    <label for="message"><?=$GLOBALS['dblang_message'][$DLANG]?> <div name="message" id=""message><?=$tbl_message?></div></label><br>
    <label for="file"><?=$GLOBALS['dblang_file'][$DLANG]?> <input id="file" class="messages" type=text name="file" value="<?=$tbl_file?>" readonly></label><br>
    <label for="type"><?=$GLOBALS['dblang_type'][$DLANG]?> <input id="type" class="messages" type=text name="type" value="<?=$tbl_type?>" readonly></label><br>
    <label for="from_url"><?=$GLOBALS['dblang_from_url'][$DLANG]?> <a id="from_url" class="messages" name="from_url" href="<?=$tbl_from_url?>"><?=$tbl_from_url?></a></label><br>
    <label for="date"><?=$GLOBALS['dblang_date'][$DLANG]?> <input id="date" class="messages" type=text name="date" value="<?=date("d-m-Y",($tbl_date[$lang])?$tbl_date[$lang]:time())?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)" readonly></label><br>
<!--<input type=submit class="button" name="submit" value="Отправить">-->
<input type='hidden' name='editid' value='<?= $editid ?>'>
</form>
