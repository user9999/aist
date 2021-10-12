<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) die("Access denied");
	$script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>";
set_script($script);
//delete data
if (isset($_GET['del']) && isset($_GET['table'])) {
    mysql_query("DELETE FROM ".$PREFIX."".$_GET['table']." WHERE id='{$_GET['del']}'");
    mysql_query("DELETE FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['del']}' and table_name='".$_GET['table']."'");
    header("Location: ?component=order"); 
}
//edit page
if (isset($_GET['edit']) && $_GET['table']=='order') {
    $res = mysql_query("select * from ".$PREFIX."order WHERE id=".$_GET['edit']);
	
    if ($row = mysql_fetch_assoc($res)) {
        foreach($row as $name=>$value){
            $n="tbl_".$name;
            ${$n} = $value;
        }
        $editid = $row['id'];
$res1 = mysql_query("SELECT * FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['edit']}' and table_name='order'");

        while($row1=mysql_fetch_assoc($res1)){
            foreach($row1 as $name=>$value){
                $n="tbl_".$name;
                ${$n}[$row1['language']] = $value;
            }
        }
        if($MY_URL==1){
            $query="SELECT * FROM ".$PREFIX."url WHERE cmsurl='order/{$_GET['edit']}' LIMIT 1";
            $result=mysql_query($query);
            $urlrow= mysql_fetch_array($result);
            $url=$urlrow['url'];
            
        }
	}
}
if (isset($_POST['submit'])) {
	$rel_id=$id=intval($_POST['editid']);
	$error="";
        if($MY_URL==1){
            $url=mysql_real_escape_string($_POST['url']);
        }
	$name=(strlen($_POST['name'])>3)?mysql_real_escape_string($_POST['name']):$error.=$GLOBALS['dblang_ErName1'][$DLANG];
$phone=(strlen($_POST['phone'])>3)?mysql_real_escape_string($_POST['phone']):$error.=$GLOBALS['dblang_ErPhone1'][$DLANG];
$address=(strlen($_POST['address'])>3)?mysql_real_escape_string($_POST['address']):$error.=$GLOBALS['dblang_ErAddress1'][$DLANG];
$email=(strlen($_POST['email'])>3)?mysql_real_escape_string($_POST['email']):$error.=$GLOBALS['dblang_ErEmail1'][$DLANG];
$user_id=(strlen($_POST['user_id'])>3)?mysql_real_escape_string($_POST['user_id']):$error.=$GLOBALS['dblang_ErUser_id1'][$DLANG];
$delivery=(strlen($_POST['delivery'])>3)?mysql_real_escape_string($_POST['delivery']):$error.=$GLOBALS['dblang_ErDelivery1'][$DLANG];
$mounting=(strlen($_POST['mounting'])>3)?mysql_real_escape_string($_POST['mounting']):$error.=$GLOBALS['dblang_ErMounting1'][$DLANG];
$date=(strlen($_POST['date'])>3)?mysql_real_escape_string($_POST['date']):$error.=$GLOBALS['dblang_ErDate1'][$DLANG];
$status=(strlen($_POST['status'])>3)?mysql_real_escape_string($_POST['status']):$error.=$GLOBALS['dblang_ErStatus1'][$DLANG];
$change_date=(strlen($_POST['change_date'])>3)?mysql_real_escape_string($_POST['change_date']):$error.=$GLOBALS['dblang_ErChange_date1'][$DLANG];
$total_price=(strlen($_POST['total_price'])>3)?mysql_real_escape_string($_POST['total_price']):$error.=$GLOBALS['dblang_ErTotal_price1'][$DLANG];

        if($MY_URL==1){
            $frm_url=mysql_real_escape_string($_POST['url']);
            if(chpu_check($frm_url,'order/'.$_POST['editid'])=='exists'){
                $error.='Введённый ЧПУ -"'.$alias.'" уже есть в базе<br />';
            }
        }
	if($error==""){
            mysql_query("UPDATE `".$PREFIX."order` SET name='{$name}',phone='{$phone}',address='{$address}',email='{$email}',user_id='{$user_id}',delivery='{$delivery}',mounting='{$mounting}',date='{$date}',status='{$status}',change_date='{$change_date}',total_price='{$total_price}' WHERE id=$id");
            if($MY_URL==1){
                if(chpu_check($frm_url,'order/'.$_POST['editid'])=='update'){
                    $query="UPDATE ".$PREFIX."url SET url='{$url}' WHERE cmsurl='order/{$_POST['editid']}'";
                }else{
                    $query="INSERT INTO ".$PREFIX."url SET url='{$url}',component='static',cmsurl='order/{$_POST['editid']}'";
                }
            }        foreach($_POST['stufflang'] as $num=>$language){
				$title=mysql_real_escape_string($_POST['title'][$language]);
$short=mysql_real_escape_string($_POST['short'][$language]);
$content=mysql_real_escape_string($_POST['content'][$language]);
$description=mysql_real_escape_string($_POST['description'][$language]);
$keywords=mysql_real_escape_string($_POST['keywords'][$language]);
$pub_date=(strlen($_POST['pub_date'][$language])>6)?strtotime($_POST['pub_date'][$language]):time();
                $res=mysql_query("select id from ".$PREFIX."lang_text where rel_id={$rel_id} and table_name='order' and language='{$language}'");
                if(mysql_num_rows($res)>0){
                    mysql_query("UPDATE `".$PREFIX."lang_text` SET title='{$title}',short='{$short}',content='{$content}',description='{$description}',keywords='{$keywords}',pub_date='{$pub_date}' WHERE rel_id=$rel_id and table_name='order' and language='$language'");
                } else {
                    mysql_query("INSERT INTO `".$PREFIX."lang_text` SET rel_id={$rel_id} ,table_name='order',language='{$language}',title='{$title}',short='{$short}',content='{$content}',description='{$description}',keywords='{$keywords}',pub_date='{$pub_date}'");
                }
            }
	} else {
        echo $error.$multierror;
    }
}
?>
<h1>Редактирование</h1><form method="post"><label for="name"><?=$GLOBALS['dblang_name'][$DLANG]?> <textarea id="name" class="ckeditor" id="editor_ck11m[<?= $lang ?>]" name="name"><?=$tbl_name?></textarea></label><br>
<label for="phone"><?=$GLOBALS['dblang_phone'][$DLANG]?> <input id="phone" class="mainform order" type=text name="phone" value="<?=$tbl_phone?>"></label><br>
<label for="address"><?=$GLOBALS['dblang_address'][$DLANG]?> <textarea id="address" class="ckeditor" id="editor_ck13m[<?= $lang ?>]" name="address"><?=$tbl_address?></textarea></label><br>
<label for="email"><?=$GLOBALS['dblang_email'][$DLANG]?> <input id="email" class="mainform order" type=text name="email" value="<?=$tbl_email?>"></label><br>
<label for="user_id"><?=$GLOBALS['dblang_user_id'][$DLANG]?> <input id="user_id" class="mainform order" type=text name="user_id" value="<?=$tbl_user_id?>"></label><br>
<label for="delivery"><?=$GLOBALS['dblang_delivery'][$DLANG]?> <input id="delivery" class="mainform order" type=text name="delivery" value="<?=$tbl_delivery?>"></label><br>
<label for="mounting"><?=$GLOBALS['dblang_mounting'][$DLANG]?> <input id="mounting" class="mainform order" type=text name="mounting" value="<?=$tbl_mounting?>"></label><br>
<label for="date"><?=$GLOBALS['dblang_date'][$DLANG]?> <input id="date" class="mainform order" type=text name="date" value="<?=date("d-m-Y",($tbl_date[$lang])?$tbl_date[$lang]:time())?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"></label><br>
<label for="status"><?=$GLOBALS['dblang_status'][$DLANG]?> <input id="status" class="mainform order" type=text name="status" value="<?=$tbl_status?>"></label><br>
<label for="change_date"><?=$GLOBALS['dblang_change_date'][$DLANG]?> <input id="change_date" class="mainform order" type=text name="change_date" value="<?=date("d-m-Y",($tbl_change_date[$lang])?$tbl_change_date[$lang]:time())?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"></label><br>
<label for="total_price"><?=$GLOBALS['dblang_total_price'][$DLANG]?> <input id="total_price" class="mainform order" type=text name="total_price" value="<?=$tbl_total_price?>"></label><br>

<?php
if($MY_URL==1){
?>
        <label for="url">URL(ЧПУ):
            <input id="url" class="mainform order" name="url" type="text"  value="<?php echo $url??'' ?>">
        </label><br>  
<?php
}
?>

<?php
foreach($LANGUAGES as $lang=>$path){
?>
<div class=lang>Язык : <?= $lang ?></div>
<input type=hidden name="stufflang[]" value="<?= $lang ?>">
		<label for="title[<?= $lang ?>]"><?=$GLOBALS['dblang_title1'][$DLANG]?><input id="title[<?= $lang ?>]" type=text name="title[<?= $lang ?>]" value="<?=$tbl_title[$lang]?>"></label><label for="short[<?= $lang ?>]"><?=$GLOBALS['dblang_short1'][$DLANG]?><textarea id="short[<?= $lang ?>]" class="ckeditor" id="editor_ck12[<?= $lang ?>]" name="short[<?= $lang ?>]"><?=$tbl_short[$lang]?></textarea></label><label for="content[<?= $lang ?>]"><?=$GLOBALS['dblang_content1'][$DLANG]?><textarea id="content[<?= $lang ?>]" class="ckeditor" id="editor_ck13[<?= $lang ?>]" name="content[<?= $lang ?>]"><?=$tbl_content[$lang]?></textarea></label><label for="description[<?= $lang ?>]"><?=$GLOBALS['dblang_description1'][$DLANG]?><input id="description[<?= $lang ?>]" type=text name="description[<?= $lang ?>]" value="<?=$tbl_description[$lang]?>"></label><label for="keywords[<?= $lang ?>]"><?=$GLOBALS['dblang_keywords1'][$DLANG]?><input id="keywords[<?= $lang ?>]" type=text name="keywords[<?= $lang ?>]" value="<?=$tbl_keywords[$lang]?>"></label><label for="pub_date[<?= $lang ?>]"><?=$GLOBALS['dblang_pub_date1'][$DLANG]?><input id="pub_date[<?= $lang ?>]" type=text name="pub_date[<?= $lang ?>]" value="<?=date("d-m-Y",($tbl_pub_date[$lang])?$tbl_pub_date[$lang]:time())?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"></label>
<?php
}	
?><input type=submit class=button name="submit" value="<?=$GLOBALS['dblang_button'][$DLANG]?>">
<input type='hidden' name='editid' value='<?= $editid ?>'>
</form>
//delete data
if (isset($_GET['del']) && isset($_GET['table'])) {
    mysql_query("DELETE FROM ".$PREFIX."".$_GET['table']." WHERE id='{$_GET['del']}'");
    mysql_query("DELETE FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['del']}' and table_name='".$_GET['table']."'");
    header("Location: ?component=order"); 
}
//edit page
if (isset($_GET['edit']) && $_GET['table']=='order_units') {
    $res = mysql_query("select * from ".$PREFIX."order_units WHERE id=".$_GET['edit']);
	
    if ($row = mysql_fetch_assoc($res)) {
        foreach($row as $name=>$value){
            $n="tbl_".$name;
            ${$n} = $value;
        }
        $editid = $row['id'];
$res1 = mysql_query("SELECT * FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['edit']}' and table_name='order_units'");

        while($row1=mysql_fetch_assoc($res1)){
            foreach($row1 as $name=>$value){
                $n="tbl_".$name;
                ${$n}[$row1['language']] = $value;
            }
        }
        if($MY_URL==1){
            $query="SELECT * FROM ".$PREFIX."url WHERE cmsurl='order/{$_GET['edit']}' LIMIT 1";
            $result=mysql_query($query);
            $urlrow= mysql_fetch_array($result);
            $url=$urlrow['url'];
            
        }
	}
}
if (isset($_POST['submit'])) {
	$rel_id=$id=intval($_POST['editid']);
	$error="";
        if($MY_URL==1){
            $url=mysql_real_escape_string($_POST['url']);
        }
	$order_id=(strlen($_POST['order_id'])>3)?mysql_real_escape_string($_POST['order_id']):$error.=$GLOBALS['dblang_ErOrder_id2'][$DLANG];
$product_id=(strlen($_POST['product_id'])>3)?mysql_real_escape_string($_POST['product_id']):$error.=$GLOBALS['dblang_ErProduct_id2'][$DLANG];
$parameters=(strlen($_POST['parameters'])>3)?mysql_real_escape_string($_POST['parameters']):$error.=$GLOBALS['dblang_ErParameters2'][$DLANG];
$amount=(strlen($_POST['amount'])>3)?mysql_real_escape_string($_POST['amount']):$error.=$GLOBALS['dblang_ErAmount2'][$DLANG];
$price=(strlen($_POST['price'])>3)?mysql_real_escape_string($_POST['price']):$error.=$GLOBALS['dblang_ErPrice2'][$DLANG];

        if($MY_URL==1){
            $frm_url=mysql_real_escape_string($_POST['url']);
            if(chpu_check($frm_url,'order/'.$_POST['editid'])=='exists'){
                $error.='Введённый ЧПУ -"'.$alias.'" уже есть в базе<br />';
            }
        }
	if($error==""){
            mysql_query("UPDATE `".$PREFIX."order_units` SET order_id='{$order_id}',product_id='{$product_id}',parameters='{$parameters}',amount='{$amount}',price='{$price}' WHERE id=$id");
            if($MY_URL==1){
                if(chpu_check($frm_url,'order/'.$_POST['editid'])=='update'){
                    $query="UPDATE ".$PREFIX."url SET url='{$url}' WHERE cmsurl='order/{$_POST['editid']}'";
                }else{
                    $query="INSERT INTO ".$PREFIX."url SET url='{$url}',component='static',cmsurl='order/{$_POST['editid']}'";
                }
            }        foreach($_POST['stufflang'] as $num=>$language){
				$title=mysql_real_escape_string($_POST['title'][$language]);
$short=mysql_real_escape_string($_POST['short'][$language]);
$content=mysql_real_escape_string($_POST['content'][$language]);
$description=mysql_real_escape_string($_POST['description'][$language]);
$keywords=mysql_real_escape_string($_POST['keywords'][$language]);
$pub_date=(strlen($_POST['pub_date'][$language])>6)?strtotime($_POST['pub_date'][$language]):time();
                $res=mysql_query("select id from ".$PREFIX."lang_text where rel_id={$rel_id} and table_name='order_units' and language='{$language}'");
                if(mysql_num_rows($res)>0){
                    mysql_query("UPDATE `".$PREFIX."lang_text` SET title='{$title}',short='{$short}',content='{$content}',description='{$description}',keywords='{$keywords}',pub_date='{$pub_date}' WHERE rel_id=$rel_id and table_name='order_units' and language='$language'");
                } else {
                    mysql_query("INSERT INTO `".$PREFIX."lang_text` SET rel_id={$rel_id} ,table_name='order_units',language='{$language}',title='{$title}',short='{$short}',content='{$content}',description='{$description}',keywords='{$keywords}',pub_date='{$pub_date}'");
                }
            }
	} else {
        echo $error.$multierror;
    }
}
?>
<h1>Редактирование</h1><form method="post"><label for="order_id"><?=$GLOBALS['dblang_order_id'][$DLANG]?> <input id="order_id" class="mainform order" type=text name="order_id" value="<?=$tbl_order_id?>"></label><br>
<label for="product_id"><?=$GLOBALS['dblang_product_id'][$DLANG]?> <input id="product_id" class="mainform order" type=text name="product_id" value="<?=$tbl_product_id?>"></label><br>
<label for="parameters"><?=$GLOBALS['dblang_parameters'][$DLANG]?> <textarea id="parameters" class="ckeditor" id="editor_ck23m[<?= $lang ?>]" name="parameters"><?=$tbl_parameters?></textarea></label><br>
<label for="amount"><?=$GLOBALS['dblang_amount'][$DLANG]?> <input id="amount" class="mainform order" type=text name="amount" value="<?=$tbl_amount?>"></label><br>
<label for="price"><?=$GLOBALS['dblang_price'][$DLANG]?> <input id="price" class="mainform order" type=text name="price" value="<?=$tbl_price?>"></label><br>

<?php
if($MY_URL==1){
?>
        <label for="url">URL(ЧПУ):
            <input id="url" class="mainform order" name="url" type="text"  value="<?php echo $url??'' ?>">
        </label><br>  
<?php
}
?>

<?php
foreach($LANGUAGES as $lang=>$path){
?>
<div class=lang>Язык : <?= $lang ?></div>
<input type=hidden name="stufflang[]" value="<?= $lang ?>">
		<label for="title[<?= $lang ?>]"><?=$GLOBALS['dblang_title2'][$DLANG]?><input id="title[<?= $lang ?>]" type=text name="title[<?= $lang ?>]" value="<?=$tbl_title[$lang]?>"></label><label for="short[<?= $lang ?>]"><?=$GLOBALS['dblang_short2'][$DLANG]?><textarea id="short[<?= $lang ?>]" class="ckeditor" id="editor_ck22[<?= $lang ?>]" name="short[<?= $lang ?>]"><?=$tbl_short[$lang]?></textarea></label><label for="content[<?= $lang ?>]"><?=$GLOBALS['dblang_content2'][$DLANG]?><textarea id="content[<?= $lang ?>]" class="ckeditor" id="editor_ck23[<?= $lang ?>]" name="content[<?= $lang ?>]"><?=$tbl_content[$lang]?></textarea></label><label for="description[<?= $lang ?>]"><?=$GLOBALS['dblang_description2'][$DLANG]?><input id="description[<?= $lang ?>]" type=text name="description[<?= $lang ?>]" value="<?=$tbl_description[$lang]?>"></label><label for="keywords[<?= $lang ?>]"><?=$GLOBALS['dblang_keywords2'][$DLANG]?><input id="keywords[<?= $lang ?>]" type=text name="keywords[<?= $lang ?>]" value="<?=$tbl_keywords[$lang]?>"></label><label for="pub_date[<?= $lang ?>]"><?=$GLOBALS['dblang_pub_date2'][$DLANG]?><input id="pub_date[<?= $lang ?>]" type=text name="pub_date[<?= $lang ?>]" value="<?=date("d-m-Y",($tbl_pub_date[$lang])?$tbl_pub_date[$lang]:time())?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"></label>
<?php
}	
?><input type=submit class=button name="submit" value="<?=$GLOBALS['dblang_button'][$DLANG]?>">
<input type='hidden' name='editid' value='<?= $editid ?>'>
</form>
