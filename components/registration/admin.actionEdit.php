<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
}
    $script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>";
set_script($script);
//delete data
if (isset($_GET['del']) && isset($_GET['table'])) {
    mysql_query("DELETE FROM ".$PREFIX."".$_GET['table']." WHERE id='{$_GET['del']}'");
    mysql_query("DELETE FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['del']}' and table_name='".$_GET['table']."'");
    header("Location: ?component=static"); 
}
//edit page
if (isset($_GET['edit']) && $_GET['table']=='') {
    $res = mysql_query("select * from ".$PREFIX." WHERE id=".$_GET['edit']);
    
    if ($row = mysql_fetch_assoc($res)) {
        foreach($row as $name=>$value){
            $n="tbl_".$name;
            ${$n} = $value;
        }
        $editid = $row['id'];$res1 = mysql_query("SELECT * FROM ".$PREFIX."users WHERE rel_id='{$_GET['edit']}'");

        while($row1=mysql_fetch_assoc($res1)){
            foreach($row1 as $name=>$value){
                $n="tbl_".$name;
                ${$n}[$row1['language']] = $value;
            }
        }
    }
}
if (isset($_POST['submit'])) {
    $rel_id=$id=intval($_POST['editid']);
    $error="";
    
    if($error=="") {
        mysql_query("UPDATE `".$PREFIX."` SET WHERE id=$id");        foreach($_POST['stufflang'] as $num=>$language){
            $nick=mysql_real_escape_string($_POST['nick'][$language]);
            $parent_id=mysql_real_escape_string($_POST['parent_id'][$language]);
            $email=mysql_real_escape_string($_POST['email'][$language]);
            $phone=mysql_real_escape_string($_POST['phone'][$language]);
            $name=mysql_real_escape_string($_POST['name'][$language]);
            $gender=mysql_real_escape_string($_POST['gender'][$language]);
            $birthdate=mysql_real_escape_string($_POST['birthdate'][$language]);
            $country=mysql_real_escape_string($_POST['country'][$language]);
            $firm=mysql_real_escape_string($_POST['firm'][$language]);
            $password=mysql_real_escape_string($_POST['password'][$language]);
            $actype=mysql_real_escape_string($_POST['actype'][$language]);
            $percent=mysql_real_escape_string($_POST['percent'][$language]);
            $udata=mysql_real_escape_string($_POST['udata'][$language]);
            $money=mysql_real_escape_string($_POST['money'][$language]);
            $amount=mysql_real_escape_string($_POST['amount'][$language]);
            $level=mysql_real_escape_string($_POST['level'][$language]);
            $ref_amount=mysql_real_escape_string($_POST['ref_amount'][$language]);
            $points=mysql_real_escape_string($_POST['points'][$language]);
            $regdate=mysql_real_escape_string($_POST['regdate'][$language]);
            $ref2_amount=mysql_real_escape_string($_POST['ref2_amount'][$language]);
            $ref3_amount=mysql_real_escape_string($_POST['ref3_amount'][$language]);
            $ref4_amount=mysql_real_escape_string($_POST['ref4_amount'][$language]);
            $getref=mysql_real_escape_string($_POST['getref'][$language]);
            $systemref=mysql_real_escape_string($_POST['systemref'][$language]);
            $tmp_pass=mysql_real_escape_string($_POST['tmp_pass'][$language]);
            $package=mysql_real_escape_string($_POST['package'][$language]);
            $payed_till=mysql_real_escape_string($_POST['payed_till'][$language]);

            $res=mysql_query("select id from ".$PREFIX."lang_text where rel_id={$rel_id} and table_name='' and language='{$language}'");
            if(mysql_num_rows($res)>0) {
                mysql_query("UPDATE `".$PREFIX."users` SET nick='{$nick}',parent_id='{$parent_id}',email='{$email}',phone='{$phone}',name='{$name}',gender='{$gender}',birthdate='{$birthdate}',country='{$country}',firm='{$firm}',password='{$password}',actype='{$actype}',percent='{$percent}',udata='{$udata}',money='{$money}',amount='{$amount}',level='{$level}',ref_amount='{$ref_amount}',points='{$points}',regdate='{$regdate}',ref2_amount='{$ref2_amount}',ref3_amount='{$ref3_amount}',ref4_amount='{$ref4_amount}',getref='{$getref}',systemref='{$systemref}',tmp_pass='{$tmp_pass}',package='{$package}',payed_till='{$payed_till}' WHERE rel_id=$rel_id and table_name='' and language='$language'");
            } else {
                mysql_query("INSERT INTO `".$PREFIX."users` SET rel_id={$rel_id} ,nick='{$nick}',parent_id='{$parent_id}',email='{$email}',phone='{$phone}',name='{$name}',gender='{$gender}',birthdate='{$birthdate}',country='{$country}',firm='{$firm}',password='{$password}',actype='{$actype}',percent='{$percent}',udata='{$udata}',money='{$money}',amount='{$amount}',level='{$level}',ref_amount='{$ref_amount}',points='{$points}',regdate='{$regdate}',ref2_amount='{$ref2_amount}',ref3_amount='{$ref3_amount}',ref4_amount='{$ref4_amount}',getref='{$getref}',systemref='{$systemref}',tmp_pass='{$tmp_pass}',package='{$package}',payed_till='{$payed_till}'");
            }
        }
    } else {
        echo $error.$multierror;
    }
}
?>
<h1>Редактирование</h1><form method="post">
<?php
foreach($LANGUAGES as $lang=>$path){
    ?>
<div class=lang>Язык : <?php echo $lang ?></div>
<input type=hidden name="stufflang[]" value="<?php echo $lang ?>">
        <label for="nick[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_nick1'][$DLANG]?><input id="nick[<?php echo $lang ?>]" type=text name="nick[<?php echo $lang ?>]" value="<?php echo $tbl_nick[$lang]?>"></label><label for="parent_id[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_parent_id1'][$DLANG]?><input id="parent_id[<?php echo $lang ?>]" type=text name="parent_id[<?php echo $lang ?>]" value="<?php echo $tbl_parent_id[$lang]?>"></label><label for="email[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_email1'][$DLANG]?><input id="email[<?php echo $lang ?>]" type=text name="email[<?php echo $lang ?>]" value="<?php echo $tbl_email[$lang]?>"></label><label for="phone[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_phone1'][$DLANG]?><input id="phone[<?php echo $lang ?>]" type=text name="phone[<?php echo $lang ?>]" value="<?php echo $tbl_phone[$lang]?>"></label><label for="name[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_name1'][$DLANG]?><input id="name[<?php echo $lang ?>]" type=text name="name[<?php echo $lang ?>]" value="<?php echo $tbl_name[$lang]?>"></label><label for="gender[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_gender1'][$DLANG]?><input id="gender[<?php echo $lang ?>]" type=text name="gender[<?php echo $lang ?>]" value="<?php echo $tbl_gender[$lang]?>"></label><label for="birthdate[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_birthdate1'][$DLANG]?><input id="birthdate[<?php echo $lang ?>]" type=text name="birthdate[<?php echo $lang ?>]" value="<?php echo date("d-m-Y", ($tbl_birthdate[$lang])?$tbl_birthdate[$lang]:time())?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"></label><label for="country[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_country1'][$DLANG]?><input id="country[<?php echo $lang ?>]" type=text name="country[<?php echo $lang ?>]" value="<?php echo $tbl_country[$lang]?>"></label><label for="firm[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_firm1'][$DLANG]?><input id="firm[<?php echo $lang ?>]" type=text name="firm[<?php echo $lang ?>]" value="<?php echo $tbl_firm[$lang]?>"></label><label for="password[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_password1'][$DLANG]?><input id="password[<?php echo $lang ?>]" type=text name="password[<?php echo $lang ?>]" value="<?php echo $tbl_password[$lang]?>"></label><label for="actype[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_actype1'][$DLANG]?><input id="actype[<?php echo $lang ?>]" type=text name="actype[<?php echo $lang ?>]" value="<?php echo $tbl_actype[$lang]?>"></label><label for="percent[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_percent1'][$DLANG]?><input id="percent[<?php echo $lang ?>]" type=text name="percent[<?php echo $lang ?>]" value="<?php echo $tbl_percent[$lang]?>"></label><label for="udata[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_udata1'][$DLANG]?><input id="udata[<?php echo $lang ?>]" type=text name="udata[<?php echo $lang ?>]" value="<?php echo $tbl_udata[$lang]?>"></label><label for="money[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_money1'][$DLANG]?><input id="money[<?php echo $lang ?>]" type=text name="money[<?php echo $lang ?>]" value="<?php echo $tbl_money[$lang]?>"></label><label for="amount[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_amount1'][$DLANG]?><input id="amount[<?php echo $lang ?>]" type=text name="amount[<?php echo $lang ?>]" value="<?php echo $tbl_amount[$lang]?>"></label><label for="level[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_level1'][$DLANG]?><input id="level[<?php echo $lang ?>]" type=text name="level[<?php echo $lang ?>]" value="<?php echo $tbl_level[$lang]?>"></label><label for="ref_amount[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_ref_amount1'][$DLANG]?><input id="ref_amount[<?php echo $lang ?>]" type=text name="ref_amount[<?php echo $lang ?>]" value="<?php echo $tbl_ref_amount[$lang]?>"></label><label for="points[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_points1'][$DLANG]?><input id="points[<?php echo $lang ?>]" type=text name="points[<?php echo $lang ?>]" value="<?php echo $tbl_points[$lang]?>"></label><label for="regdate[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_regdate1'][$DLANG]?><input id="regdate[<?php echo $lang ?>]" type=text name="regdate[<?php echo $lang ?>]" value="<?php echo date("d-m-Y", ($tbl_regdate[$lang])?$tbl_regdate[$lang]:time())?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"></label><label for="ref2_amount[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_ref2_amount1'][$DLANG]?><input id="ref2_amount[<?php echo $lang ?>]" type=text name="ref2_amount[<?php echo $lang ?>]" value="<?php echo $tbl_ref2_amount[$lang]?>"></label><label for="ref3_amount[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_ref3_amount1'][$DLANG]?><input id="ref3_amount[<?php echo $lang ?>]" type=text name="ref3_amount[<?php echo $lang ?>]" value="<?php echo $tbl_ref3_amount[$lang]?>"></label><label for="ref4_amount[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_ref4_amount1'][$DLANG]?><input id="ref4_amount[<?php echo $lang ?>]" type=text name="ref4_amount[<?php echo $lang ?>]" value="<?php echo $tbl_ref4_amount[$lang]?>"></label><label for="getref[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_getref1'][$DLANG]?><input id="getref[<?php echo $lang ?>]" type=text name="getref[<?php echo $lang ?>]" value="<?php echo $tbl_getref[$lang]?>"></label><label for="systemref[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_systemref1'][$DLANG]?><input id="systemref[<?php echo $lang ?>]" type=text name="systemref[<?php echo $lang ?>]" value="<?php echo $tbl_systemref[$lang]?>"></label><label for="tmp_pass[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_tmp_pass1'][$DLANG]?><input id="tmp_pass[<?php echo $lang ?>]" type=text name="tmp_pass[<?php echo $lang ?>]" value="<?php echo $tbl_tmp_pass[$lang]?>"></label><label for="package[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_package1'][$DLANG]?><input id="package[<?php echo $lang ?>]" type=text name="package[<?php echo $lang ?>]" value="<?php echo $tbl_package[$lang]?>"></label><label for="payed_till[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_payed_till1'][$DLANG]?><input id="payed_till[<?php echo $lang ?>]" type=text name="payed_till[<?php echo $lang ?>]" value="<?php echo $tbl_payed_till[$lang]?>"></label>
    <?php
}    
?><input type=submit name="submit" value="<?php echo $GLOBALS['dblang_button'][$DLANG]?>">
<input type='hidden' name='editid' value='<?php echo $editid ?>'>
</form>
