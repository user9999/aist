<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
} 

function showForms($error = "", $arr)
{
    if (!$_COOKIE['cart_item_id'] || count($_COOKIE['cart_item_id']) == 0) { header("Location: " . $GLOBALS['PATH'] . "/order/noitems");
    }
    set_title("Оформление заказа");
    $err = 0;
    $query = "SELECT COUNT(*) FROM ".$PREFIX."catalog_items WHERE 1 = 0";
    foreach ($_COOKIE['cart_item_id'] as $k => $v) {
        $query .= " OR id = $v";
    }
    //echo $query;
    $res = mysql_query($query);
    $row = mysql_fetch_row($res);
    if ($row[0] != count($_COOKIE['cart_item_id'])) { $err = 1;
    }
    render_to_template("components/order/template.showOrder.php", array('error' => $err));
    render_to_template("components/order/template.showOrder2.php", array('error' => $error, "items" => $arr));
}

//recounting
if (isset($_POST['frm_count'])) {
    foreach ($_POST['frm_count'] as $k => $v) {
        $k = (int) $k;
        setcookie("cart_item_count[$k]", (int) $v, time() + 60 * 60 * 24 * 7, "/");
    }
    header("Location: " . $GLOBALS['PATH'] . "/order");
}

//deleting
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    setcookie("cart_item_id%5B$id%5D", "", time() - 3600, '/');
    setcookie("cart_item_count%5B$id%5D", "", time() - 3600, '/');
    header("Location: " . $GLOBALS['PATH'] . "/order");
}
if (isset($_GET['clearall'])) {
    foreach ($_COOKIE['cart_item_id'] as $k => $v) {
        setcookie("cart_item_id%5B$k%5D", "", time() - 3600, '/');
        //setcookie("cart_item_count%5B$k%5D", "", time() - 3600, '/');
    }
    foreach ($_COOKIE['cart_item_count'] as $k => $v) {
        //setcookie("cart_item_id%5B$k%5D", "", time() - 3600, '/');
        setcookie("cart_item_count%5B$k%5D", "", time() - 3600, '/');
    }
    setcookie("cart_count", "", time() - 3600, '/');
    header("Location: " . $GLOBALS['PATH'] . "/order");
}
//order
if (isset($_POST['frm_name'])) {
    $frm_name = mysql_real_escape_string(strip_tags($_POST['frm_name']));
    $frm_phone = preg_replace("/[^0-9+]/", "", $_POST['frm_phone']);
    $frm_address = mysql_real_escape_string(strip_tags($_POST['frm_address']));
    
    $error = "";
    if (strlen($frm_name) < 5) { $error .= "Слишком короткое имя заказчика.<br />";
    }
    if (strlen($frm_phone) < 5) { $error .= "Неверный номер телефона.<br />";
    }
    //if (strlen($frm_address) < 5) $error .= "Слишком короткий контактный адрес.<br />";
    if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $_POST['frm_email'])) { $error .= "Неверный e-mail.<br />";
    }
    if (count($_POST['frm_item_id']) == 0) { $error = "<b>Нет товаров для заказа.</b><br />";
    }
    
    if (!$error) {
        mysql_query("INSERT INTO ".$PREFIX."orders SET name = '$frm_name', phone = '$frm_phone', address = '$frm_address', email = '{$_POST['frm_email']}', date = '" . date('U') . "', state = 0");
        $id = mysql_insert_id();
        foreach ($_POST['frm_item_id'] as $k => $v) {
            $n_id = (int) $v;
            
            $n_count=str_replace(",", ".", $_POST['frm_item_count'][$k]);
            
            //$n_count = (int) $_POST['frm_item_count'][$k];
            
            $res = mysql_query("SELECT * FROM ".$PREFIX."catalog_items WHERE id = $n_id");
            if ($row = mysql_fetch_row($res)) {
                $row[18]=str_replace(",", ".", $row[18]);
                $n_count=$n_count/$row[18];
                $row[9] = (float) $row[9];
                mysql_query("INSERT INTO ".$PREFIX."orders_items SET orders_id = $id, name = '{$row[2]}', price = '{$row[9]}', quantity = '$n_count', item_id = '{$row[0]}', action = '{$row[12]}'");
            }
        }



        $lettitle="Новый заказ на фермерское мясо";
        $from="robot@фермерское-мясо.рф";
        $ltitle="=?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $lettitle))."?=";
        $mess="Оформлен новый заказ на сайте фермерское мясо. Вы можете просмотреть его по ссылке: http://xn----itbaaykendmcmf4a0p.xn--p1ai/admin/?component=order&order_id=$id";
        $mess=iconv("UTF-8", "koi8-r", $mess);
        $headers="From: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", "Фермерское мясо"))."?= <".trim($from).">\r\nReply-to: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", "От кого"))."?= <".trim($from).">\r\nContent-type: text/html; charset=koi8-r\r\nContent-Transfer-Encoding: 8bit\r\n";
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
