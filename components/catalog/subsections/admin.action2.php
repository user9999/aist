<?php if (!defined("ADMIN_SIMPLE_CMS")) die("Access denied"); 

//delete static page
if (isset($_GET['del'])) {
    mysql_query("DELETE FROM catalog_sections WHERE id='{$_GET['del']}'");
    header("Location: ?component=catalog&action=2"); 
}
if (isset($_GET['delbrand'])) {
    mysql_query("DELETE FROM catalog_brands WHERE id='{$_GET['del']}'");
    //header("Location: ?component=catalog&action=2"); 
}

$tbl_name = "";
$tbl_brand_id = "";
$tbl_altname = "";
$tbl_image = "";
$tbl_showimg = "";
$editid = 0;
//edit static page
if (isset($_GET['edit'])) {
	$brands="";
    $res = mysql_query("SELECT * FROM catalog_sections WHERE id='{$_GET['edit']}'");
    if ($row = mysql_fetch_row($res)) {
        $tbl_name = $row[1];
		//$tbl_brand_id = $row[1];
		$tbl_altname = $row[2];
		$tbl_image = $row[10];
		$tbl_showimg = $row[9];
		$tbl_sortby = unserialize($row[11]);
        $editid = $row[0];
    }
	$res11 = mysql_query("SELECT * FROM catalog_brands WHERE subsection_id='{$_GET['edit']}'");
	//echo "SELECT * FROM catalog_brands WHERE subsection_id='{$_GET['edit']}'";
	 if (mysql_num_rows($res11)) {
		$brands.="<tr><td>Бренды</td><td>";
		while($row11=mysql_fetch_row($res11)){
			$row11[2]=($row11[2])?$row11[2]:$row11[1];
			$brands.="<input name=brand[".$row11[0]."] value='".$row11[1]."'> - Отображаемое название <input name=altbrand[".$row11[0]."] value='".$row11[2]."'> &nbsp;&nbsp;&nbsp;<a href='/admin/?component=catalog&action=2&edit=162&delbrand=".$row11[0]."' title='удалить бренд'><img src='/images/del.png' alt='удалить бренд'></a><br>";
		}
		$brands.="</td><tr>";
	 }
}

//add new static page
if (isset($_POST['frm_name'])) {
    $frm_name = $_POST['frm_name'];//str_replace(" ","_",strtolower($_POST['frm_name']));
	$frm_altname = $_POST['frm_altname'];
	//$frm_brand_id = (int) $_POST['frm_brand_id'];
	$frm_image = $_POST['frm_image'];
	//$frm_showimg = 0;
	foreach($_POST['frm_column'] as $num=>$val){
		$sort[$num+1]=$_POST['frm_column_name'][$num];
	}
	$sort=serialize($sort);
	//var_dump($sort);
	//die();
	if ($_POST['frm_showimg']) $frm_showimg = 1;
	
    if (strlen($frm_name) >= 2) {
        if (!$_POST['editid']) {
		//die("INSERT INTO catalog_subsections SET  name='$frm_name', altname='$frm_altname', img = '$frm_image',sortby='$sort'");
            mysql_query("INSERT INTO catalog_sections SET  name='$frm_name', altname='$frm_altname', img = '$frm_image',sortby='$sort'");
        } else {
		//die("UPDATE catalog_sections SET  name='$frm_name',  altname='$frm_altname', img = '$frm_image',sortby='$sort' WHERE id={$_POST['editid']}");
            mysql_query("UPDATE catalog_sections SET  name='$frm_name',  altname='$frm_altname', img = '$frm_image',sortby='$sort' WHERE id={$_POST['editid']}");
        }
        header("Location: ?component=catalog&action=2");
    } else echo "<br /><br /><b>Ошибка.</b> Минимальная длина названия - 2 символа";
}
if($_POST['update_pos']){
 //mydump($_POST['pos'],'pkey');
  foreach($_POST['pos'] as $pval=>$pkey){
 
    mysql_query("UPDATE catalog_subsections SET position=".$pkey." where id=".$pval);
	if($pkey!=0){
	//mydump("UPDATE catalog_subsections SET position=".$pkey." where id=".$pval);
	}
  }
}
?>

<br /><br />
<h1>Управление подразделами каталога</h1>
<form method="post">
    <table width="100%">
        <tr>
            <td width="130">Название латинскими буквами(id раздела):</td><td><input class="textbox" name="frm_name" type="text" style="width: 100%;" value="<?= $tbl_name ?>"></td>
        </tr>
		<tr>
            <td width="130"><b>Русское название:</b></td><td><input class="textbox" name="frm_altname" type="text" style="width: 100%;" value="<?= $tbl_altname ?>"></td>
        </tr>
        <tr>
            <td width="130">Изображение (ссылка):</td><td><input class="textbox" name="frm_image" type="text" style="width: 100%;" value="<?= $tbl_image ?>"></td>
        </tr>
        <!--<tr>
			<td>Показывать изображения позиций:</td><td><input type="checkbox" name="frm_showimg" <?php if ($tbl_showimg) echo "checked"; ?>></td>
        </tr>
		<tr>
            <td width="130">Раздел:</td><td>
				<select name="frm_brand_id">
					<?php
					$res = mysql_query("SELECT * FROM catalog_sections ORDER BY name");
					while ($row = mysql_fetch_row($res)) {
						if ($row[2]) $row[1] = $row[2];
						echo "<option ";
						if ($tbl_brand_id == $row[0]) echo "selected ";
						echo "value='{$row[0]}'>{$row[1]}</option>";
					} 
					?>
				</select>
			</td>
        </tr>-->
		<tr>
			<td>Сортировка:</td><td>
			<div class=inputs>column1 <input type="checkbox" name="frm_column[]" <?php if ($tbl_sortby[1]) echo "checked"; ?> value=1> <input type="text" name="frm_column_name[]" value="<?php echo $tbl_sortby[1]; ?>"></div>
			<div class=inputs>column2 <input type="checkbox" name="frm_column[]" <?php if ($tbl_sortby[2]) echo "checked"; ?> value=1> <input type="text" name="frm_column_name[]" value="<?php echo $tbl_sortby[2]; ?>"></div>
			<div class=inputs>column3 <input type="checkbox" name="frm_column[]" <?php if ($tbl_sortby[3]) echo "checked"; ?> value=1> <input type="text" name="frm_column_name[]" value="<?php echo $tbl_sortby[3]; ?>"></div>
			<div class=inputs>column4 <input type="checkbox" name="frm_column[]" <?php if ($tbl_sortby[4]) echo "checked"; ?> value=1> <input type="text" name="frm_column_name[]" value="<?php echo $tbl_sortby[4]; ?>"></div>
			</td>
        </tr>
		<?php echo $brands ?>
		<tr> 
            <td colspan="2" align="right"><input type='hidden' name='editid' value='<?= $editid ?>'><input type="submit" class="button" value="Сохранить"></td>
        </tr>
    </table>
</form>
Обратите внимание на следующие особенности - альтернативное название не является обязательным, но если оно задано, то используется для отображения в каталоге.
<br />
<br />
<h1>Существующие подразделы</h1><form method="post"><table class=underline>
<?php
$res = mysql_query("SELECT * FROM catalog_sections order by id");
$num = 0;
while ($row = mysql_fetch_array($res)) {
	$res1=mysql_query("SELECT id FROM catalog_sections where parent={$row[0]}");
	if(mysql_num_rows($res1)==0){
		$num++;
		if ($row[2]) $row[1] = $row[2];
		echo "<tr><td><b>" . $row['name']."</b></td><td>".$row['altname'] . "</td><td> <a href='?component=catalog&action=2&edit={$row[0]}'>[редактировать]</a> <a href='?component=catalog&action=2&del={$row[0]}'>[удалить]</a></td></tr>";	
	}
    
	//<br />
	$res2 = mysql_query("SELECT * FROM catalog_subsections WHERE section_id = $row[0] ORDER by position");
	while ($row2 = mysql_fetch_row($res2)) {
		if (!$row2[3]) $row2[3] = "так же";
		echo " <tr><td>&nbsp; &nbsp; " . $row2[2] . " ( " . $row2[3] . ")</td><td>" . " <a href='?component=catalog&action=2&edit={$row2[0]}'>[редактировать]</a> <a href='?component=catalog&action=2&del={$row2[0]}'>[удалить]</a></td><td><input type=\"Text\" name=\"pos[".$row2[0]."]\" value=\"".$row2[7]."\" style=\"width:25px;margin-left:70px\" /></td></tr>";//<br />
	}
}
echo "<tr style=\"text-align:center\"><td colspan=\"3\"><br /><input class=\"button\" type=\"submit\" name=\"update_pos\" value=\"Упорядочить\" /></td></tr></table>";
if ($num == 0) echo "Пожалуйста, сначала добавьте хотя бы один бренд";
?>
</form>