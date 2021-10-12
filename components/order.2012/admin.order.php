<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 
$script="<script language=JavaScript src=\"".$GLOBALS['PATH']."/inc/popup_lib.js\"></script>
<script language=JavaScript src=\"".$GLOBALS['PATH']."/inc/dateselector.js\"></script>
<link href=\"".$GLOBALS['PATH']."/inc/dateselector.css\" type=text/css rel=stylesheet>";
set_script($script);
render_to_template("components/order/template.admin.menu.php", "");
if (isset($_GET['order_id'])) {
    $order_id = (int) $_GET['order_id'];
    $res = mysql_query("SELECT * FROM ".$PREFIX."orders WHERE id = $order_id");
    if(isset($_GET['item_id'])) {
        $res4=mysql_query("select a.price,a.quantity,b.user_id from ".$PREFIX."orders_items as a, orders as b where a.id=".$_GET['item_id']." and a.orders_id=b.id limit 1");
        $row4=mysql_fetch_row($res4);
    
        mysql_query("update ".$PREFIX."users set money=money+".$row4[0].",amount=amount+".$row4[1]." where id='".$row4[2]."'");
        mysql_query("update ".$PREFIX."orders_items set payed=1 where id=".$_GET['item_id']);
    }

    if ($row = mysql_fetch_array($res)) {
        //show needed order
        $res2 = mysql_query("SELECT a.*,b.description,b.provider FROM ".$PREFIX."orders_items as a,".$PREFIX."catalog_items as b WHERE a.name=b.name and a.orders_id = {$row[0]} order by  b.country,b.section,b.brand_id,b.model_id,b.description");//, SUM(price) as sumprice
        //echo "SELECT *, SUM(price) as sumprice FROM orders_items WHERE orders_id = {$row[0]}";
        while ($row2 = @mysql_fetch_array($res2)) {
            $arr[] = $row2;
        }
        @render_to_template("components/order/template.admin.showOrder.php", array("order" => $row, 'items' => $arr));
    } else { header("Location: ?component=order");
    }
} else {
    if (isset($_GET['del_id'])) {
        $del_id = (int) $_GET['del_id'];
        mysql_query("DELETE FROM ".$PREFIX."orders WHERE id = $del_id");
        mysql_query("DELETE FROM ".$PREFIX."orders_items WHERE orders_id = $del_id");
        header("Location: " . $GLOBALS['PATH'] . "/admin/?component=order&action=2");
    }
    if (isset($_GET['ok_id'])) {
        $ok_id = (int) $_GET['ok_id'];
        mysql_query("UPDATE ".$PREFIX."orders set state=1 WHERE id = $ok_id");
    }    
    //show orders page
    $state=($_GET['action']==2)?"state=1":"state=0";
    $date="";
    
    if($_GET['action']==2) {
        $date="AND `date`>".(time()-60*60*24*30);
        if($_POST['show']) {
            $date="AND `date`>".strtotime($_POST['fromdate'])." AND `date`<".(strtotime($_POST['tilldate'])+60*60*24);
        }
    }

    $res = mysql_query("SELECT * FROM ".$PREFIX."orders where $state $date ORDER BY utype DESC,date DESC");
    $i=0;
    while ($row = mysql_fetch_array($res)) {
        $currency=($row['currency']!='')?$row['exrate']*$row['ratio']:1;
        $res2 = mysql_query("SELECT price,quantity FROM ".$PREFIX."orders_items WHERE orders_id = {$row[0]}");
        if(mysql_num_rows($res2)>0) {
            $i++;
            $row['num']=$i;
            $row['sum']=0;
            $row['price']=0;
            while($row2 = mysql_fetch_row($res2)){
                $row['price']+=(floor($row2[0]*$currency))*$row2[1];
                $row['sum']+=$row2[1];
            }
            $row['action']=($_GET['action']==2)?"delete":"history";
            if ($row['price']) { render_to_template("components/order/template.admin.showList.php", $row);
            }
        }
        /*
        if ($row2 = mysql_fetch_row($res2)) {
        $row['price'] = $row2[0];
        if ($row['price']) render_to_template("components/order/template.admin.showList.php", $row);
        }
        */
    }
}
?>
