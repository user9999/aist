<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 
echo "<br /><br /><br /><h3>Список подписчиков</h3>";
mysql_query("delete from ".$PREFIX."submission where code!=0 and subdate<".time()-7*24*60*60);
$res=mysql_query("select email,name,code,subdate from ".$PREFIX."submission order by subdate DESC");
$out="<table><tr><td>Имя</td><td>email</td><td>Дата подписки</td><td>статус</td></tr>";
while($row=mysql_fetch_row($res)){
    $status=($row[2]==='0')?"<td style=\"color:#090\">Получает</td>":"<td style=\"color:#f22\">Не активирован</td>";
    $out.="<tr><td><b>$row[1]</b></td><td><i>$row[0]</i></td><td>".date("Hч:iмин d-m-Y", $row[3])."</td>".$status."</tr>";

}
$out.="</table>";
echo $out;
?>


