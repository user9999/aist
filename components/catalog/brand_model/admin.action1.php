<?php if (!defined("ADMIN_SIMPLE_CMS")) die('Access denied'); 
//delete static page
if(isset($_GET['del'])){
    mysql_query("DELETE FROM ".$PREFIX."catalog_brands WHERE id='{$_GET['del']}'");
    header("Location: ?component=catalog"); 
}
$tbl_showmenu = 1;
//edit static page
if(isset($_GET['edit'])){
    $res=mysql_query("SELECT * FROM ".$PREFIX."catalog_brands WHERE id='{$_GET['edit']}'");
    if($row=mysql_fetch_row($res)){
        $img='img/icons/'.$row[0].'.jpg';
        $tbl_name=$row[1];
		$tbl_altname=$row[2];
		$tbl_showmenu=$row[3];
		$tbl_position=$row[4];
		$tbl_rusname=$row[5];
        $editid=$row[0];
    }
}
//add new static page
if(isset($_POST['frm_name'])){
  $frm_name=$_POST['frm_name'];
	$frm_altname=$_POST['frm_altname'];
	$frm_position=$_POST['frm_position'];
	$frm_showmenu=0;
	if($_POST['frm_showmenu']) $frm_showmenu=1;
    if (strlen($frm_name)>=3){
        if(!$_POST['editid']){
            mysql_query("INSERT INTO ".$PREFIX."catalog_brands SET showmenu='$frm_showmenu',name='$frm_name',altname='$frm_altname',position='$frm_position',rusname='{$_POST['frm_rusname']}'");
        } else {
            mysql_query("UPDATE ".$PREFIX."catalog_brands SET showmenu='$frm_showmenu',name='$frm_name',altname='$frm_altname',position='$frm_position',rusname='{$_POST['frm_rusname']}' WHERE id={$_POST['editid']}");
        }
        header("Location: ?component=catalog");
    } else echo "<b>Ошибка.</b> Минимальная длина названия - 3 символа";
}
?>
<br><br>
<h1>Управление брендами каталога</h1>
<form method=post>
<table width="100%">
<tr>
<td width=130>Название:</td><td><input class=textbox name=frm_name style="width:100%;" value="<?= $tbl_name ?>"></td>
</tr>
<tr>
<td><b>Альт. название:</b></td><td><input class=textbox name=frm_altname style="width:100%;" value="<?= $tbl_altname ?>"></td>
</tr>
<tr>
<td><b>Русское название:</b></td><td><input class=textbox name=frm_rusname style="width:100%;" value="<?= $tbl_rusname ?>"></td>
</tr>
<tr>
<td><b>Изображение:</b></td><td><input class=textbox name=img style="width:100%;" value="<?= $img ?>" readonly></td>
</tr>
<tr>
<td><b>Порядок:</b></td><td><input class=textbox name=frm_position style="width:10%;" value="<?= $tbl_position ?>"></td>
</tr>
<tr>
<td>Показывать в меню:</td><td><input type=checkbox name=frm_showmenu <?php if ($tbl_showmenu) echo "checked"; ?>></td>
</tr>
<tr> 
<td colspan="2" align="right"><input type=hidden name=editid value='<?= $editid ?>'><input type=submit class=button value="Сохранить"></td>
</tr>
</table>
</form>
Обратите внимание на следующие особенности - альтернативное название не является обязательным, но если оно задано, то используется для отображения в каталоге. Обычное же название (полученное из прайс-листа в формате CSV) используется для синхронизации БД и CSV, а также для формирования ссылок.
<br>
<br>
<h1>Существующие бренды</h1>
<?php
$res = mysql_query("SELECT * FROM ".$PREFIX."catalog_brands");
$num = 0;
while ($row = mysql_fetch_row($res)) {
    $num++;
	if (!$row[2]) $row[2] = "так же";
    echo $row[1].' (в каталоге - '.$row[2].')'.' <a href="?component=catalog&action=1&edit='.$row[0].'">[редактировать]</a> <a href="?component=catalog&action=1&del='.$row[0].'">[удалить]</a><br />';
}
if ($num == 0) echo 'Бренды не добавлены';
?>
