<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 
$script="<script language=JavaScript src=\"".$GLOBALS['PATH']."/inc/popup_lib.js\"></script>
<script language=JavaScript src=\"".$GLOBALS['PATH']."/inc/dateselector.js\"></script>
<link href=\"".$GLOBALS['PATH']."/inc/dateselector.css\" type=text/css rel=stylesheet>";
set_script($script);
render_to_template("components/preorder/template.admin.menu.php", "");

if (isset($_GET['orderid'])) {
    $order_id = (int) $_GET['orderid'];
    $res = mysql_query("SELECT a.*,b.email,b.name,b.company FROM ".$PREFIX."preorder_admin as a, ".$PREFIX."users as b WHERE b.id=a.user_id and a.id = $order_id");
    //SELECT a.*,b.email,b.name,b.company FROM preorder_admin as a, users as b where $state and b.id=a.user_id
    if(isset($_GET['item_id'])) {
        $res4=mysql_query("select a.price,a.amount,b.user_id from ".$PREFIX."preorder_items as a, ".$PREFIX."preorder as b where a.id=".$_GET['item_id']." and a.order_id=b.id limit 1");
        $row4=mysql_fetch_row($res4);
    
        mysql_query("update ".$PREFIX."users set money=money+".$row4[0].",amount=amount+".$row4[1]." where id='".$row4[2]."'");
        mysql_query("update ".$PREFIX."orders_items set payed=1 where id=".$_GET['item_id']);
    }

    if ($row = mysql_fetch_array($res)) {
        //show needed order
        $res2 = mysql_query("SELECT a.*,b.id as item_id,b.description,b.provider FROM ".$PREFIX."preorder_items as a,".$PREFIX."catalog_items as b  WHERE a.gruz_id=b.name and a.order_id = {$row[0]} order by b.country,b.section,b.brand_id,b.model_id,b.description");//, SUM(price) as sumprice
        //echo "SELECT *, SUM(price) as sumprice FROM orders_items WHERE orders_id = {$row[0]}";
        while ($row2 = @mysql_fetch_array($res2)) {
            $arr[] = $row2;
        }

        @render_to_template("components/preorder/template.admin.showOrder.php", array("order" => $row, 'items' => $arr));
    } else { header("Location: ?component=preorder");
    }
} else {
    if (isset($_GET['del_id'])) {
        $del_id = (int) $_GET['del_id'];
        mysql_query("DELETE FROM ".$PREFIX."preorder_admin WHERE id = $del_id");
        mysql_query("DELETE FROM ".$PREFIX."preorder_items WHERE orders_id = $del_id");
        header("Location: " . $GLOBALS['PATH'] . "/admin/?component=preorder&action=2");
        /*
        $del_id = (int) $_GET['del_id'];
        mysql_query("DELETE FROM orders WHERE id = $del_id");
        mysql_query("DELETE FROM orders_items WHERE orders_id = $del_id");
        header("Location: " . $GLOBALS['PATH'] . "/admin/?component=preorder&action=2");
        */
    }
    if (isset($_GET['ok_id'])) {
        $ok_id = (int) $_GET['ok_id'];
        mysql_query("UPDATE ".$PREFIX."preorder_admin set perform_date=".time()." WHERE id = $ok_id");
    }    
    //show orders page
    
    switch($_GET['action']){
    case 1:
        $state="perform_date=0";
        break;
    case 2:
        $state="perform_date>10";
        break;
    default:
        $state="perform_date=0";
        break;
    }


    $date="";
    if($_GET['action']==2) {
        $date="AND a.order_date>".(time()-60*60*24*30);
        if($_POST['show']) {
            $date="AND a.order_date>".strtotime($_POST['fromdate'])." AND a.order_date<".(strtotime($_POST['tilldate'])+60*60*24);
        }
    }

    
    $res = mysql_query("SELECT a.*,b.email,b.name,b.company FROM ".$PREFIX."preorder_admin as a, ".$PREFIX."users as b where $state $date and b.id=a.user_id ORDER BY utype DESC,order_date DESC");
    $i=0;
    while ($row = mysql_fetch_array($res)) {
        $currency=($row['currency']!='')?$row['exrate']*$row['ratio']:1;
        $row['name']=($row['company'])?$row['company']:$row['name'];
        $res2 = mysql_query("SELECT price,amount FROM ".$PREFIX."preorder_items WHERE order_id = {$row[0]}");
        if(mysql_num_rows($res2)>0) {
            $i++;
            $row['num']=$i;
            $row['price']=0;$row['amount']=0;
            while($row2 = mysql_fetch_row($res2)){
                //$row['price']+=$row2[0]*$row2[1];
                $row['price']+=(floor($row2[0]*$currency))*$row2[1];
                $row['amount']+=$row2[1];
            }
            $row['action']=($_GET['action']==2)?"delete":"history";
            //echo $row['price'];
            if ($row['price']) { render_to_template("components/preorder/template.admin.showList.php", $row);
            }
        }

    }
}
?>
