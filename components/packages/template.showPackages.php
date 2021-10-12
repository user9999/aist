<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
}
echo $TEMPLATE['title'];
?>
<form method=post action="/articles/paypal">
<table>
<?php
$res=mysql_query("select a.id,a.price,b.title,b.content from packages as a, lang_text as b where b.language='{$GLOBALS['userlanguage']}' and a.id=b.rel_id and b.table_name='packages'");
while($row=mysql_fetch_row($res)){
    echo "<tr><td><input type=radio name=package value='{$row[0]}'></td><td>{$row[2]}</td><td>{$row[3]}</td><td>{$row[1]}$</td></tr> ";
}
?>
<tr><td></td><td></td><td><input type=submit name=pay value="<?php echo $GLOBALS['dblang_pay'][$GLOBALS['userlanguage']] ?>"</td><td></td></tr>
</table>
</form>
