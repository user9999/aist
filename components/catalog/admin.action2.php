<?php if (!defined("ADMIN_SIMPLE_CMS")) die("Access denied"); 

//delete static page
if (isset($_GET['del'])) {
    mysql_query("DELETE FROM catalog_models WHERE id='{$_GET['del']}'");
    header("Location: ?component=catalog&action=2"); 
}

$tbl_name = "";
$tbl_brand_id = "";
$tbl_altname = "";
$tbl_image = "";
$tbl_showimg = "";
$editid = 0;
//edit static page
if (isset($_GET['edit'])) {
    $res = mysql_query("SELECT * FROM catalog_models WHERE id='{$_GET['edit']}'");
    if ($row = mysql_fetch_row($res)) {
        $tbl_name = $row[2];
		$tbl_brand_id = $row[1];
		$tbl_altname = $row[3];
		$tbl_image = $row[4];
		$tbl_showimg = $row[5];
        $editid = $row[0];
    }
}

//add new static page
if (isset($_POST['frm_name'])) {
    $frm_name = $_POST['frm_name'];
	$frm_altname = $_POST['frm_altname'];
	$frm_brand_id = (int) $_POST['frm_brand_id'];
	$frm_image = $_POST['frm_image'];
	$frm_showimg = 0;
	if ($_POST['frm_showimg']) $frm_showimg = 1;
	
    if (strlen($frm_name) >= 2) {
        if (!$_POST['editid']) {
            mysql_query("INSERT INTO catalog_models SET showimg = '$frm_showimg', name='$frm_name', altname='$frm_altname', brand_id = '$frm_brand_id', image = '$frm_image'");
        } else {
            mysql_query("UPDATE catalog_models SET showimg = '$frm_showimg', name='$frm_name', brand_id = '$frm_brand_id', altname='$frm_altname', image = '$frm_image' WHERE id={$_POST['editid']}");
        }
        header("Location: ?component=catalog&action=2");
    } else echo "<br /><br /><b>Ошибка.</b> Минимальная длина названия - 2 символа";
}
if($_POST['update_pos']){
  foreach($_POST['pos'] as $pval=>$pkey){
    mysql_query("UPDATE catalog_models SET position=".$pkey." where id=".$pval);
  }
}
?>

<br /><br />
<h1>Управление моделями каталога</h1>
<form method="post">
    <table width="100%">
        <tr>
            <td width="130">Название:</td><td><input class="textbox" name="frm_name" type="text" style="width: 100%;" value="<?= $tbl_name ?>"></td>
        </tr>
		<tr>
            <td width="130"><b>Альт. название:</b></td><td><input class="textbox" name="frm_altname" type="text" style="width: 100%;" value="<?= $tbl_altname ?>"></td>
        </tr>
        <tr>
            <td width="130">Изображение (ссылка):</td><td><input class="textbox" name="frm_image" type="text" style="width: 100%;" value="<?= $tbl_image ?>"></td>
        </tr>
        <tr>
			<td>Показывать изображения позиций:</td><td><input type="checkbox" name="frm_showimg" <?php if ($tbl_showimg) echo "checked"; ?>></td>
        </tr>
		<tr>
            <td width="130">Бренд:</td><td>
				<select name="frm_brand_id">
					<?php
					$res = mysql_query("SELECT * FROM catalog_brands ORDER BY name");
					while ($row = mysql_fetch_row($res)) {
						if ($row[2]) $row[1] = $row[2];
						echo "<option ";
						if ($tbl_brand_id == $row[0]) echo "selected ";
						echo "value='{$row[0]}'>{$row[1]}</option>";
					} 
					?>
				</select>
			</td>
        </tr>
		<tr> 
            <td colspan="2" align="right"><input type='hidden' name='editid' value='<?= $editid ?>'><input type="submit" class="button" value="Сохранить"></td>
        </tr>
    </table>
</form>
Обратите внимание на следующие особенности - альтернативное название не является обязательным, но если оно задано, то используется для отображения в каталоге.
<br />
<br />
<h1>Существующие модели</h1><form method="post"><table>
<?php
$res = mysql_query("SELECT * FROM catalog_brands");
$num = 0;
while ($row = mysql_fetch_row($res)) {
    $num++;
	if ($row[2]) $row[1] = $row[2];
    echo "<tr><td colspan=\"3\"><b>" . $row[1] . "</b></td></tr>";//<br />
	$res2 = mysql_query("SELECT * FROM catalog_models WHERE brand_id = $row[0] ORDER by position");
	while ($row2 = mysql_fetch_row($res2)) {
		if (!$row2[3]) $row2[3] = "так же";
		echo " <tr><td>&nbsp; &nbsp; " . $row2[2] . " (в каталоге - " . $row2[3] . ")</td><td>" . " <a href='?component=catalog&action=2&edit={$row2[0]}'>[редактировать]</a> <a href='?component=catalog&action=2&del={$row2[0]}'>[удалить]</a></td><td><input type=\"Text\" name=\"pos[".$row2[0]."]\" value=\"".$row2[6]."\" style=\"width:25px;margin-left:70px\" /></td></tr>";//<br />
	}
}
echo "<tr style=\"text-align:center\"><td colspan=\"3\"><br /><input class=\"button\" type=\"submit\" name=\"update_pos\" value=\"Упорядочить\" /></td></tr></table>";
if ($num == 0) echo "Пожалуйста, сначала добавьте хотя бы один бренд";
?>
</form>