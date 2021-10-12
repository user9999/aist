<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 
//delete static page
if (isset($_GET['del'])) {
    //mysql_query("DELETE FROM services WHERE id='{$_GET['del']}'");
    //mysql_query("DELETE FROM lang_text WHERE rel_id='{$_GET['del']}' and table_name='services'");
    
    header("Location: ?component=services"); 
}
?>
<h1>Заказы</h1>
<table class=bordered>
<tr><td>Имя</td><td>тел</td><td>email</td><td>услуга</td><td>дата</td><td>когда сделан</td></tr>
<?php
$res = mysql_query("SELECT a.*,b.title FROM ".$PREFIX."service_orders as a,".$PREFIX."lang_text as b where a.product_id=b.rel_id and b.table_name='services' and b.language='{$GLOBALS[DLANG]}' order by a.day,a.month,a.year");
//echo "SELECT a.*,b.title FROM ".$PREFIX."service_orders as a,".$PREFIX."lang_text as b where a.product_id=b.rel_id and b.table_name='services' and b.language='en' order by a.day,a.month,a.year";
while ($row = mysql_fetch_assoc($res)) {
    echo "<tr class=clear><td>{$row['name']}</td><td>{$row['phone']}</td><td>{$row['email']}</td><td>{$row['title']}</td><td>{$row['day']}.{$row['month']}.{$row['year']}</td><td>".date("d-m-Y H:i", $row['date'])."</td></tr>";
}

?>
</table>