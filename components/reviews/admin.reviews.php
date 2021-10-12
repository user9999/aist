<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
}

if($_GET['cmd']=='ok' && preg_match("!^[0-9]+$!is", $_GET['id'])) {
    mysql_query("update ".$PREFIX."reviews set permittion=1 where id=".$_GET['id']);
} elseif($_GET['cmd']=='del' && preg_match("!^[0-9]+$!is", $_GET['id'])) {
    mysql_query("delete from ".$PREFIX."reviews where id=".$_GET['id']);
}

$res=mysql_query("select * from ".$PREFIX."reviews order by permittion");
$out="";
while($row=mysql_fetch_assoc($res)){
    $class=($row['permittion']==1)?"confirmed":"noconfirmed";
    $out.="<div class='$class'>
	<div class=from><a href='mailto:{$row['umail']}'>{$row['uname']}</a></div>
	<div class=date>".date("d-m-Y", $row['pubdate'])."</div>
	<div class=title>{$row['title']}</div>
	<div class=review>{$row['review']}</div>
	<div class=management>
	<a href='?component=reviews&cmd=ok&id={$row['id']}'>утвердить</a> <a href='?component=reviews&cmd=del&id={$row['id']}'>удалить</a> 
	</div>
	</div>";
}
echo $out;
?>
