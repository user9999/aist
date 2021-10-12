<?php
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 
?>

<?php

if($_POST['del']) {
    $res=mysql_query('select link from '.$PREFIX.'gallery where id='.$_POST['del']);
    $row=mysql_fetch_assoc($res);
    mysql_query("delete from ".$PREFIX."gallery where id=".$_POST['del']);
    if(file_exists($HOSTPATH.'/uploaded/gallery/'.$row['link'])) {
        unlink($HOSTPATH.'/uploaded/gallery/'.$row['link']);
    }
    if(file_exists($HOSTPATH.'/uploaded/gallery/small_'.$row['link'])) {
        unlink($HOSTPATH.'/uploaded/gallery/small_'.$row['link']);
    }
}
if($_POST['change']) {
    foreach($_POST['position'] as $name=>$value){
        $display=($_POST['display'][$name]==1)?1:0;
        $title=$_POST['title'][$name];
        $description=$_POST['description'][$name];
        mysql_query("update ".$PREFIX."gallery set title='$title',description='$description',position=$value, display=$display where id=$name");
    }

}
$res = mysql_query("SELECT id,link,title,description,date,position,display from ".$PREFIX."gallery ORDER BY position,date");
$front="<div><form method=\"post\"><table class=items><tr><td></td><td><input class='button' type='submit' name='change' value='Изменить' /></td></tr>
<!--<tr><td>Изображение</td><td>Название</td><td>Порядок</td><td>Отображать</td><td>Удаление</td></tr>-->";
if($res && mysql_num_rows($res)>0) {
    //var_dump($res);
    while ($row = mysql_fetch_row($res)) {
        $check=($row[6]==1)?" checked":"";
        $front.="<tr style='vertical-align:top'>
	<td><img src='".$PATH."/uploaded/gallery/small_".$row[1]."' alt='' /></td>
	<td><div class=iteminfo>Название<br><input type=text name='title[".$row[0]."]' value='".$row[2]."'><br>
	Описание<br><textarea name=description[".$row[0]."]>$row[3]</textarea></div>
	<div class=stuff>
	<div class=first>картинка:</div><div class=sec> /uploaded/gallery/small_".$row[1]."</div><div class=clear></div>
	<div class=first>Порядковый номер:</div><div class=sec><input type='text' name='position[".$row[0]."]' value='".$row[5]."' size='2' /></div><div class=clear></div>
	<div class=first>Отображать:</div><div class=sec><input type='checkbox' name='display[".$row[0]."]' value='1'$check /></div><div class=clear></div>
	<div class=first>Удаление:</div><div class=sec><input style='font-size:0;border:0;cursor:pointer;width:20px;height:20px;background:url(".$PATH."/img/del.gif) no-repeat' type='submit' name='del' value='$row[0]' /></div></div>
	</td></tr>";
    }
}
$front.="<tr><td></td><td></td><td><input class='button' type='submit' name='change' value='Изменить' /></td><td></td><td></td></tr></table></form></div>";

echo $front;
?>
