<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
$script="<script language=JavaScript src=\"".$GLOBALS['PATH']."/inc/popup_lib.js\"></script>
<script language=JavaScript src=\"".$GLOBALS['PATH']."/inc/dateselector.js\"></script>
<link href=\"".$GLOBALS['PATH']."/inc/dateselector.css\" type=text/css rel=stylesheet>";
set_script($script);
if($_SESSION['userid']) {
    $orders="";
    $preorders="";
    $pdate="AND order_date>".(time()-60*60*24*30);
    $odate="AND `date`>".(time()-60*60*24*30);
    if($_POST['show']) {
        $pdate="AND order_date>".strtotime($_POST['fromdate'])." AND order_date<".(strtotime($_POST['tilldate'])+60*60*24);
        $odate="AND `date`>".strtotime($_POST['fromdate'])." AND `date`<".(strtotime($_POST['tilldate'])+60*60*24);
    }
    $res=mysql_query("SELECT id,order_date,perform_date FROM ".$PREFIX."preorder_admin WHERE user_id='{$_SESSION['userid']}' $pdate order by id desc");
    $preorders="<table cellspacing=7>";
    while($row=mysql_fetch_row($res)){
        $img=($row[2])?"<img src=\"img/ok.png\" alt=\"Заказ обработан\" title=\"Заказ обработан\">":"<img src=\"img/wait.png\" alt=\"Заказ получен\" title=\"Заказ получен\">";
        $preorders.="<tr><td>$img</td><td>№".$row[0]." </td><td style=\"font-style:italic;font-weight:normal\"> ".date("Hч.:iмин. d-m-Y", $row[1])."</td><td style=\"width:80px\"> <a href=\"javascript:void(0)\" style=\"display:block;float:left\" onclick=\"window.open('usercsv.php?preorder_history=".$row[0]."','pcsv','width=200,height=180,top=0,left=0,resize=0')\"><img src=\"/img/csv.png\" style=\"display:block;float:left\" alt=\"\" title=\"Скачать одним файлом\"> CSV</a> 
  <a href=\"javascript:void(0)\" style=\"display:block\" onclick=\"window.open('userxls.php?preorder_history=".$row[0]."','pcsv','width=200,height=180,top=0,left=0,resize=0')\"><img src=\"/img/csv.png\" style=\"display:block;float:left\" alt=\"\" title=\"Скачать одним файлом\"> XLS</a></td></tr>";//<!--".date("H:i d-m-Y",$row[1])."-->
    }
    $preorders.="</table>";
    $res=mysql_query("SELECT id,`date`,state FROM ".$PREFIX."orders WHERE user_id='{$_SESSION['userid']}' $odate order by id desc");
    $orders="<table cellspacing=7>";
    while($row=mysql_fetch_row($res)){
        $img=($row[2])?"<img src=\"img/ok.png\" alt=\"Заказ обработан\" title=\"Заказ обработан\">":"<img src=\"img/wait.png\" alt=\"Заказ получен\" title=\"Заказ получен\">";
        $orders.="<tr><td>$img</td><td>№".$row[0]." </td><td style=\"font-style:italic;font-weight:normal\"> ".date("Hч.:iмин. d-m-Y", $row[1])."</td><td style=\"width:80px\"><a href=\"javascript:void(0)\" style=\"display:block;float:left\" onclick=\"window.open('usercsv.php?order_history=".$row[0]."','ocsv','width=200,height=180,top=0,left=0,resize=0')\"><img src=\"/img/csv.png\" style=\"display:block;float:left\" alt=\"\" title=\"Скачать одним файлом\"> CSV</a> 
  <a href=\"javascript:void(0)\" style=\"display:block\" onclick=\"window.open('userxls.php?order_history=".$row[0]."','ocsv','width=200,height=180,top=0,left=0,resize=0')\"><img src=\"/img/csv.png\" style=\"display:block;float:left\" alt=\"\" title=\"Скачать одним файлом\"> XLS</a></td></tr>";//<!--".date("H:i d-m-Y",$row[1])."-->
    }
    $orders.="</table>";
    $from=($_POST['fromdate'])?$_POST['fromdate']:date("d.m.Y", (time()-60*60*24*30));
    $till=($_POST['tilldate'])?$_POST['tilldate']:date("d.m.Y", time());
    if($_POST['show']) {
        $interval="период с ".date("d.m.Y", strtotime($_POST['fromdate']))." по ".date("d.m.Y", strtotime($_POST['tilldate']));
    } else {
        $interval="последний месяц";
    }
    ?>
<br/>
<h2>История за <?php echo $interval ?></h2>
<br/>
<div style="width:100%;height:auto;">
<form name="main" method="post">
От: <input name="fromdate" value="<?php echo $from ?>" type="text"><img onclick="popUpCalendar(this, main.fromdate, 'dd.mm.yyyy');" src="/img/date_selector.gif" border="0" height="18" hspace="3" width="16">
До: <input name="tilldate" value="<?php echo $till ?>" type="text"><img onclick="popUpCalendar(this, main.tilldate, 'dd.mm.yyyy');" src="/img/date_selector.gif" border="0" height="18" hspace="3" width="16">
<input type="submit" name="show" value="Показать" />
</form>
</div>
<table cellspacing=30><tr style="vertical-align:top;font-size:11px;font-weight:bold;"><td>
<h2>История предварительных заказов</h2>
    <?php echo $preorders;?>
</td><td>
<h2>История заказов</h2>
    <?php echo $orders;?>
</td></tr>
</table>
    <?php
}
?>
