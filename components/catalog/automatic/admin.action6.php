<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 
if($_POST['change']) {
    foreach($_POST['name'] as $id=>$val){
        //echo "<br>".$id." ".$val." ".$_POST['position'][$id];
        mysql_query("update ".$PREFIX."catalog_brands set name='".$val."',position=".$_POST['position'][$id]." where id=".$id);
    }

}
if($_GET['brands']) {
    $flag=0;
    $res = mysql_query("SELECT id,name,position FROM ".$PREFIX."catalog_brands where section_id={$_GET['brands']} order by position");
    //echo "SELECT name,position FROM catalog_brands where subsection_id={$_GET['brands']} order by position";
    if(mysql_num_rows($res)) {
        $flag=1;
        $out="<form method=\"post\"><table class=brands><tr><td colspan=2><input class=\"button\" type=submit name=change value='Изменить'></td></tr>
	<tr><td>Бренд</td><td>Позиция</td></tr>";
    } else {
        $out="";
    }
    while($row = mysql_fetch_row($res)){
        $out.="<tr><td><input type=text name='name[{$row[0]}]' value='{$row[1]}'></td><td><input type=text name='position[{$row[0]}]' value='{$row[2]}'></td></tr>";
    }
    if($flag==1) {
        $out.="</table></form>";
    } else {
        $out.="<p>Брендов в подразделе не найдено</p>";
    }
    echo $out;
}
?>
<h1>Существующие подразделы</h1><table class=underline>
<?php
$res = mysql_query("SELECT * FROM ".$PREFIX."catalog_sections");
$num = 0;
while ($row = mysql_fetch_row($res)) {
    $num++;
    if ($row[2]) { $row[1] = $row[2];
    }
    echo "<tr><td colspan=\"2\"><b>" . $row[1] . "</b></td></tr>";//<br />
    /*
    $res2 = mysql_query("SELECT * FROM ".$PREFIX."catalog_sections WHERE section_id = $row[0] ORDER by position");
    while ($row2 = mysql_fetch_row($res2)) {
    if (!$row2[3]) $row2[3] = "так же";
    echo " <tr><td>&nbsp; &nbsp; " . $row2[2] . " ( " . $row2[3] . ")</td><td>" . " <a href='?component=catalog&action=6&brands={$row2[0]}'>[бренды]</a></td></tr>";//<br />
    }
    */
}
echo "</table>";
if ($num == 0) { echo "Пожалуйста, сначала добавьте хотя бы один бренд";
}
?>


