<?php
if (!defined("SIMPLE_CMS")) {
    die("Access denied");
}
    //if (!isset($_GET['id'])) header("Location: " . $GLOBALS['PATH'] . "/404");
    set_title($GLOBALS['dblang_ctitle'][$GLOBALS['userlanguage']]);
    set_meta("", "");
    $script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>";
    set_script($script);
    //var_dump($segments);echo "-----------------<br>";
    //var_dump($_GET);//echo "-----------------sections";//$segments,$csection,$catalog,$last_section
    // order to DB
if ($_POST['fio']) {
    include_once $_SERVER['DOCUMENT_ROOT'].'/inc/1000sms_ru.php';
    //register user
    //echo "_POST";
    $fio=mysql_real_escape_string($_POST['fio']);
    $phone=(strlen($_POST['phone'])>9)?mysql_real_escape_string($_POST['phone']):$error.=$GLOBALS['dblang_ErPhone'][$userlanguage];
    $id_product= intval($_POST['id_product']);
    foreach ($_POST as $name=>$value) {
        $$name=mysql_real_escape_string($value);
        if (strpos($name, 'option')!==false) {
            $id_option=str_replace('option', '', $name);
            $id_options[$id_option]=$value;
        }
        //echo $name." ".$value."<br>";
    }
    $resch=mysql_query("SELECT id FROM ".$PREFIX."users WHERE phone='{$phone}'");
    //$comments='';
    $autrorization=0;
    if (mysql_num_rows($resch)>0) {
        //die("autrorization=0");
        $result="Авторизуйтесь пожалуйста";
        $rowch=mysql_fetch_array($resch);
        $user_id=$rowch[0];
        $comment="Пользователь не авторизован!  \r\n";
    } elseif (!$error) {
        $genpass=helpFactory::activate('stuff/GenPass');
        $password=$genpass->makePass(7);
        $query="INSERT into ".$PREFIX."users SET phone='{$phone}',fio='{$fio}',password='".md5($password)."'";
        //die($query);
        mysql_query($query);
        $user_id=mysql_insert_id();
        //authorization
        $_SESSION['userid'] = $user_id;
        $_SESSION['user_name'] = $fio;
        $_SESSION['actype'] = 0;
        $_SESSION['email'] = 'tm_mail@tmp_mail.mail';
        $autrorization=1;
    }
    $comments=$comment.$comments;
    //add order
    //echo $error;
    //die();
    if (!$error) {
        $orderdate=time();
        $user_id=($_SESSION['userid'])?$_SESSION['userid']:$user_id;
        $query="INSERT INTO ".$PREFIX."order SET id_user='{$user_id}', id_product='{$id_product}',city='{$city}',address='{$address}',price='{$price}',user_price='{$user_price}',comments='{$comments}',phrase='{$phrase}',orderdate={$orderdate},status='1'";
        //echo    $query;die();
        mysql_query($query);
        $id_order=mysql_insert_id();
        foreach ($id_options as $id_options=>$val) {
            //echo $query;
            $query="INSERT INTO ".$PREFIX."order_options SET id_order={$id_order},id_options={$id_options},value='{$val}'";
            mysql_query($query);
        }//send sms
        if ($autrorization==1) {
            $mysms=helpFactory::activate('stuff/SendSMS');
            $mysms->sms($phone, "Ваш пароль ".$password);
        }
        $result.=" Заказ отправлен";
    } else {
        $result.=$error;
    }
}

render_to_template("components/product/tpl/Header.php", array('title'=>$GLOBALS['dblang_ctitle'][$userlanguage],'menu'=>$GLOBALS['ssubmenu'],'error'=>$error));
if ($_POST['pay']) {
}
if (!$error and $_POST['phone']) {
    $query="SELECT * FROM ".$PREFIX."services WHERE id=2";
    $res=mysql_query($query);
    $row=mysql_fetch_array($res);
    $row['id_order']=$id_order;
    $row['id_product']=$id_product;
    render_to_template("components/product/tpl/user.Services.php", $row);
}
if ($segments[2] && (!$_POST['phone'] or $error)) {
    $where=($segments[2])?' and a.id='.intval($segments[2]):'';
    
    $where=($segments[2])?" and ".$PREFIX."product.id=".intval($segments[2]):'';
    //echo $where."===";
    //ok SELECT kvn_product.*,kvn_lang_text.* FROM kvn_product LEFT OUTER JOIN kvn_lang_text on kvn_product.id=kvn_lang_text.rel_id and kvn_lang_text.table_name='product' and kvn_lang_text.language='ru' and kvn_product.id=6 LIMIT 1
    //$query="SELECT a.*,b.language as language,b.title,b.short,b.content,b.description,b.keywords,b.pub_date from ".$PREFIX."product as a,".$PREFIX."lang_text as b WHERE a.id=b.rel_id and b.table_name='product' and b.language='{$GLOBALS['userlanguage']}'$where LIMIT 1";
    $query="SELECT ".$PREFIX."product.*,".$PREFIX."lang_text.* FROM ".$PREFIX."product LEFT OUTER JOIN ".$PREFIX."lang_text on ".$PREFIX."product.id=".$PREFIX."lang_text.rel_id and ".$PREFIX."lang_text.table_name='product' and ".$PREFIX."lang_text.language='{$GLOBALS['userlanguage']}'$where LIMIT 1";
    //echo $query;
    $res2=mysql_query($query);
    while ($row2=mysql_fetch_assoc($res2)) {
        $row2['result']=$result;
        render_to_template("components/product/tpl/FullList.php", $row2);
    }

    if ($segments[2]) {
        $product_id=intval($segments[2]);
        
        
        $options_array=get_options($product_id);
        //var_dump($options_array);
        render_to_template("components/product/tpl/OptionsList.php", $options_array);
    }
} elseif ($_GET['frm_searchfield']!='' && (!$_POST['phone'] or $error)) {
    $table="queries";
    $field='phrase';
    $post=mysql_real_escape_string(trim($_GET['frm_searchfield']));
    if (strpos($post, " ")!=false) {
        $parts=explode(' ', $post);
        array_unshift($parts, $post);
        foreach ($parts as $part) {
            $word=switcher($part, 1);
            $queries[]=$word;
            $qparts[]="SELECT * FROM ".$PREFIX."{$table} WHERE ".$field."  LIKE '".$word."%'";
        }
        //$where="'".implode("%' or ".$field." LIKE '",$queries)."%'";
        $fullquery=implode(" UNION ", $qparts);
    } else {
        $word=switcher($post, 1);
        $where="'".$word."%'";
        $fullquery="SELECT * FROM ".$PREFIX."{$table} WHERE {$field} LIKE {$where}";
    }
    $fullquery.=" LIMIT 10";

    $result=mysql_query($fullquery);
    if (mysql_num_rows($result)) {
        $categories=array();
        while ($row= mysql_fetch_array($result)) {
            //$sections[$row['id']]=$row;
            $category=unserialize($row['url']);
            $categories=array_merge($categories, $category);
        }
        array_unique($categories);
        //var_dump($categories);
        $tpl['categories']=$categories;
        $tpl['h1']="Результаты поиска по запросу &laquo;".$post."&raquo;";
        render_to_template("components/product/tpl/QueryResults.php", $tpl);
    } else {
        $word=switcher($post, 1);
        $query="INSERT INTO ".$PREFIX."{$table} SET {$field}='{$word}'";
        mysql_query($query);
        //echo "inserting";
    }
    
    $phrase= mysql_real_escape_string($_GET['frm_searchfield']);
    $tpl['phrase']=$phrase;
    $tpl['city']=($city)?$city:$_COOKIE['city'];
    render_to_template("components/product/tpl/Query.php", $tpl);
}
