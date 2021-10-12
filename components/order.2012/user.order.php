<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
} 

function showForms($error = "", $arr)
{
    $res=mysql_query("SELECT COUNT(*) FROM ".$PREFIX."cart WHERE user_id='{$_SESIION['userid']}'");
    if(mysql_num_rows($res)==0) { header("Location: " . $GLOBALS['PATH'] . "/order/noitems");
    }
    set_title("Оформление заказа");
    $err = 0;
    //////делаем
    $carttime=time()-3600*24*7;
    mysql_query("delete from ".$PREFIX."cart where add_date<$carttime");
    render_to_template("components/order/template.Order.php", array('error' => $err));
    render_to_template("components/order/template.Order2.php", array('error' => $error, "items" => $arr));
}

//recounting
////переделать
if (isset($_POST['frm_count'])) {
    foreach ($_POST['frm_count'] as $k => $v) {
        if($v==0) {
            mysql_query("delete from ".$PREFIX."cart where id=$k and user_id='{$_SESSION['userid']}'");
        } else {
            mysql_query("update ".$PREFIX."cart set amount=$v where id=$k and user_id='{$_SESSION['userid']}'");
        }
    }
    header("Location: " . $GLOBALS['PATH'] . "/order");
}

//deleting
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $res=mysql_query("select amount from ".$PREFIX."cart where id=$id and user_id='{$_SESSION['userid']}' limit 1");
    if(mysql_num_rows($res)==1) {
        $row=mysql_fetch_row($res);
        if($row[0]==1) {
            mysql_query("delete from ".$PREFIX."cart where id=$id and user_id='{$_SESSION['userid']}'");
        } else {
            $amt=$row[0]-1;
            mysql_query("update ".$PREFIX."cart set amount=$amt where id=$id and user_id='{$_SESSION['userid']}'");
        }
    }
    header("Location: " . $GLOBALS['PATH'] . "/order");
}
if (isset($_GET['clearall'])) {

    mysql_query("delete from ".$PREFIX."cart where user_id='{$_SESSION['userid']}'");
    header("Location: " . $GLOBALS['PATH'] . "/order/noitems");
    
}
//order
if (isset($_POST['frm_name'])) {

    $frm_name = mysql_real_escape_string(strip_tags($_POST['frm_name']));
    $frm_phone = preg_replace("/[^0-9+]/", "", $_POST['frm_phone']);
    $frm_address = mysql_real_escape_string(strip_tags($_POST['frm_address']));
    
    $error = "";
    if (strlen($frm_name) < 5) { $error .= "Слишком короткое имя заказчика.<br />";
    }
    if (strlen($frm_phone) < 5 && !$_SESSION['userid']) { $error .= "Неверный номер телефона.<br />";
    }
    //if (strlen($frm_address) < 5) $error .= "Слишком короткий контактный адрес.<br />";
    if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $_POST['frm_email'])) { $error .= "Неверный e-mail.<br />";
    }
    if (count($_POST['frm_item_id']) == 0) { $error = "<b>Нет товаров для заказа.</b><br />";
    }
    
    if (!$error) {

        $usrid=($_SESSION['userid'])?",user_id='".$_SESSION['userid']."'":"";
        if($_SESSION['userid'] && $_SESSION['actype'][0]==1) {
            $utype=" utype=2";

        } elseif($_SESSION['userid'] && $_SESSION['actype'][0]!=1) {
            $utype=" utype=1";

        } else {
            $utype=" utype=0"; 
        }
    
        //валюта
        $cquery="";
        if($_SESSION['actype'][0]==1 && $_SESSION['actype'][6]==1) {
            $res4=mysql_query("select euro,dollar,currency,ratio from ".$PREFIX."currency where id=1");
            $row4=mysql_fetch_array($res4);
            $currency=",currency='".$row4['currency']."'";
            $exrate=",exrate='".$row4[$row4['currency']]."'";
            $ratio=",ratio='".$row4['ratio']."'";
            $cquery=$currency.$exrate.$ratio;
      
        }
        //валюта
        mysql_query("INSERT INTO ".$PREFIX."orders SET name = '$frm_name', phone = '$frm_phone', address = '$frm_address', email = '{$_POST['frm_email']}', date = '" . date('U') . "', state = 0,".$utype.$usrid.$cquery);
        $id = mysql_insert_id();
        foreach ($_POST['frm_item_id'] as $k => $v) {
        
        
        
            $n_id = (int) $v;
            if($_SESSION['userid'] && $_SESSION['actype'][0]==1) {
                $query="SELECT a.action,b.*, e.price as userprice, b.quantity FROM ".$PREFIX."cart as a,".$PREFIX."catalog_items AS b,`".$PREFIX."price_".$_SESSION['userid']."` AS e WHERE a.gruz_id=b.name and b.name=e.name AND b.id = $n_id";
            } elseif($_SESSION['userid'] && $_SESSION['actype'][0]!=1) {
                $query="SELECT a.action,b.*, b.price as userprice, b.quantity FROM ".$PREFIX."cart as a,".$PREFIX."catalog_items AS b WHERE a.gruz_id=b.name and b.id = $n_id";
            } else {
                $query="SELECT a.action,b.*, b.price as userprice, b.quantity FROM ".$PREFIX."cart as a,".$PREFIX."catalog_items AS b WHERE a.gruz_id=b.name and b.id = $n_id";
            }
            //echo $query;
            $n_count = (int) $_POST['frm_item_count'][$k];
            $res = mysql_query($query);
            if ($row = mysql_fetch_array($res)) {
            
            
            
                if($row['action']=='0') {
                    if($row['price']!=$row['userprice']) {
                          $row['price']=$row['userprice'];
                    }
                    $row['price']=($row['special'])?preg_replace("/[^0-9]/", "", $row['special']):$row['price'];
                    $row['price']=($_SESSION['percent']>0 && $_SESSION['actype'][0]!=1)?floor($row['price']*(100-$_SESSION['percent'])/100):$row['price'];
        
                    /*       
        
                    if($row[10]!=$row['userprice']){
                    $row[10]=$row['userprice'];
                    } else {
                    $row[10]=preg_replace("/[^0-9]/","",$row['special']);
                    }
                    $row[10]=($_SESSION['userid'] && $_SESSION['percent']>0 && $_SESSION['actype'][0]!=1 && $row['special']=='')?floor($row[10]*(100-$_SESSION['percent'])/100):$row[10];
                    $row[10] = (float) $row[10];
                    */
                }
                
                
                ////////check
                $spec=($row['special'])?"Старая цена ".$row['special']:"";
                mysql_query("INSERT INTO ".$PREFIX."orders_items SET orders_id = $id, name = '{$row[3]}', price = '{$row['price']}', quantity = '$n_count', item_id = '{$row[1]}', action='".$spec."'");//.$usrid
                //echo "INSERT INTO orders_items SET orders_id = $id, name = '{$row[3]}', price = '{$row[10]}', quantity = '$n_count', item_id = '{$row[1]}', action='".$spec."'";
            }
        }
        mysql_query("delete from ".$PREFIX."cart where user_id='{$_SESSION['userid']}'");
        $lettitle="Новый заказ на ".$PATH;
        $from=$ADMIN_EMAIL;
        $ltitle="=?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $lettitle))."?=";
        $mess="Оформлен новый заказ на сайте ".$PATH." от ".$_SESSION['user_name'].". Вы можете просмотреть его по ссылке: ".$PATH."/admin/?component=order&order_id=$id";
        $mess=iconv("UTF-8", "koi8-r", $mess);
        $headers="From: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $SITE_TITLE))."?= <".trim($from).">\r\nReply-to: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", "От кого"))."?= <".trim($from).">\r\nContent-type: text/html; charset=koi8-r\r\nContent-Transfer-Encoding: 8bit\r\n";
        mail($GLOBALS[ADMIN_EMAIL], $ltitle, $mess, $headers);
        foreach ($_COOKIE['cart_item_id'] as $k => $v) {
            setcookie("cart_item_id%5B$k%5D", "", time() - 3600, '/');
            setcookie("cart_item_count%5B$k%5D", "", time() - 3600, '/');
        }
        
        header("Location: " . $GLOBALS['PATH'] . "/order/success");
    } else { showForms($error, array("name" => $frm_name, "phone" => $frm_phone, "address" => $frm_address, "email" => $frm_email));
    }
} elseif ($_GET['id'] == 'success') {
    set_title("Успешный заказ");
    render_to_template("components/order/template.orderSuccess.php", array());
} elseif ($_GET['id'] == 'noitems') {
    set_title("Оформление заказа");
    render_to_template("components/order/template.orderEmpty.php", array());
} else {
    showForms(0, array("name" => "", "phone" => "", "address" => "", "email" => ""));
}
?>
