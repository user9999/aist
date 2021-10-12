<?php if (!defined("SIMPLE_CMS")) die("Access denied");
//if (!isset($_GET['id'])) header("Location: " . $GLOBALS['PATH'] . "/404");
set_title($GLOBALS['dblang_ctitle'][$GLOBALS['userlanguage']]);
set_meta("", "");
$script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>";
set_script($script);
render_to_template("components/order/tpl/Header.php",array('title'=>$GLOBALS['dblang_ctitle'][$userlanguage],'menu'=>$GLOBALS['ssubmenu']));

if($_POST['total_price']){
    //dump_html($_POST);die();
    $error="";
    $name=mysql_real_escape_string($_POST['name']);
    $phone=mysql_real_escape_string($_POST['phone']);
    $address=mysql_real_escape_string($_POST['address']);
    $email=mysql_real_escape_string($_POST['email']);
    $delivery=intval($_POST['delivery']);
    $mounting=intval($_POST['mounting']);
    $date=time();
    $status=1;
    $total_price=mysql_real_escape_string($_POST['total_price']);


    if($error==""){
        mysql_query("INSERT INTO `".$PREFIX."order` SET name='{$name}',phone='{$phone}',address='{$address}',email='{$email}',user_id='{$user_id}',delivery='{$delivery}',mounting='{$mounting}',date='{$date}',status='{$status}',change_date='{$change_date}',total_price='{$total_price}'");
        $order_id=$id=mysql_insert_id();
        echo $order_id;
        foreach($_POST['price'] as $product_id=>$value){
            $parameters=($_POST['parameters'][$product_id])?json_encode($_POST['parameters'][$product_id]):'';
            $amount=intval($_POST['amount'][$product_id]);
            $price=mysql_real_escape_string($_POST['price'][$product_id]);
            mysql_query("INSERT INTO `".$PREFIX."order_units` SET order_id='{$order_id}',product_id='{$product_id}',parameters='{$parameters}',amount='{$amount}',price='{$price}'");
        
        }
        
    }
    
}
render_to_template("components/order/tpl/Order.php",array('message'=>'Заказ отправлен в работу'));

$res = mysql_query("select * from ".$PREFIX."order");

$num = 0;
while ($row = mysql_fetch_assoc($res)) {

    //$tt=$row[1];
$res1=mysql_query("SELECT title FROM ".$PREFIX."lang_text where table_name='order' and rel_id={$row['id']} and language='{$GLOBALS['userlanguage']}'");
    while($row1=mysql_fetch_array($res1)){
        $tt=$row1[0];
        $row['lang_title']=$row1[0];
        render_to_template("components/order/tpl/List.php",$row);
    }
    $num++;

}
$res = mysql_query("select * from ".$PREFIX."order_units");
$num = 0;
while ($row = mysql_fetch_assoc($res)) {

    //$tt=$row[1];
$res1=mysql_query("SELECT title FROM ".$PREFIX."lang_text where table_name='order_units' and rel_id={$row['id']} and language='{$GLOBALS['userlanguage']}'");
    while($row1=mysql_fetch_array($res1)){
        $tt=$row1[0];
        $row['lang_title']=$row1[0];
        render_to_template("components/order/tpl/List.php",$row);
    }
    $num++;

}if ($num == 0) echo $GLOBALS['dblang_norecords'][$GLOBALS['userlanguage']];
?>