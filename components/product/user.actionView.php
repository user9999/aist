<?php
if (!defined("SIMPLE_CMS")) {
    die("Access denied");
}
    //if (!isset($_GET['id'])) header("Location: " . $GLOBALS['PATH'] . "/404");
    set_title($GLOBALS['dblang_ctitle'][$GLOBALS['userlanguage']]);
    set_meta("", "");
    $script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>";
    set_script($script);

    
    
        // order to DB
    if ($_POST['submit']) {
        require_once $_SERVER['DOCUMENT_ROOT'].'/inc/1000sms_ru.php';
        //register user
        $id_product=mysql_real_escape_string($_POST['id_product']);
        foreach ($_POST as $name=>$value) {
            $$name=mysql_real_escape_string($value);
            if (strpos($name, 'option')!==false) {
                $id_option=str_replace('option', '', $name);
                $id_options[$id_option]=$value;
            }
            //echo $name." ".$value."<br>";
        }
        //var_dump($id_options);
        $orderdate=time();
    
        //add order
        mysql_query("INSERT INTO ".$PREFIX."order SET id_user='{$_SESSION['userid']}', id_product='{$id_product}',city='{$city}',address='{$address}',price='{$price}',user_price='{$user_price}',comments='{$comments}',orderdate={$orderdate},status='1'");
        $id_order=mysql_insert_id();
        foreach ($id_options as $id_options=>$val) {
            mysql_query("INSERT INTO ".$PREFIX."order_options SET id_order={$id_order},id_options={$id_options},alias='options',value='{$val}'");
        }

        $result.=" Заказ отправлен";
    }

    

    render_to_template("components/product/tpl/Header.php", array('title'=>$GLOBALS['dblang_ctitle'][$userlanguage],'menu'=>$GLOBALS['ssubmenu']));
    if ($_POST['pay']) {
        foreach ($_POST as $name=>$value) {
            $$name=mysql_real_escape_string($value);
        }
        $query="SELECT * FROM ".$PREFIX."services WHERE id={$id}";
        $res=mysql_query($query);
        $row=mysql_fetch_array($res);
        //добавтиь оплату в базу
        $query="INSERT INTO ".$PREFIX."order_options SET id_order={$id_order},alias='services',value='{$row['id']}',cur_price='{$price}'";
        mysql_query($query);
        $row['id_order']=$id_order;
        render_to_template("components/product/tpl/YandexKassa.php", $row);
    }
     if (!$error and $_POST['submit']) {
         $query="SELECT * FROM ".$PREFIX."services WHERE id=2";
         $res=mysql_query($query);
         $row=mysql_fetch_array($res);
         $row['id_order']=$id_order;
         $row['id_product']=$id_product;
         render_to_template("components/product/tpl/user.Services.php", $row);
     }
    if (!$_POST['submit'] or $error) {
        $where=($segments[2])?' and a.id='.intval($segments[2]):'';
        $res2=mysql_query("SELECT a.*,b.language as language,b.title,b.short,b.content,b.description,b.keywords,b.pub_date from ".$PREFIX."product as a,".$PREFIX."lang_text as b WHERE a.id=b.rel_id and b.table_name='product' and b.language='{$GLOBALS['userlanguage']}'$where");
        while ($row2=mysql_fetch_assoc($res2)) {
            $row2['result']=$result;
            render_to_template("components/product/tpl/user.FullList.php", $row2);
        }

        if ($segments[2]) {
            $product_id=intval($segments[2]);
            $options_array=get_options($product_id);
            //var_dump($options_array);
            render_to_template("components/product/tpl/user.OptionsList.php", $options_array);
        }
    }
