<?php if (!defined("ADMIN_SIMPLE_CMS")) die("Access denied"); 
//delete static page



$num = 0;

if (isset($_GET['del'])) {
    mysql_query("DELETE FROM catalog_sections WHERE id='{$_GET['del']}'");
    header("Location: ?component=catalog"); 
}
$tbl_showmenu = 1;
//edit static page
if (isset($_GET['edit'])) {
    $res = mysql_query("SELECT * FROM catalog_sections WHERE id='{$_GET['edit']}'");
    if ($row = mysql_fetch_row($res)) {
        $tbl_name = $row[1];
		$tbl_altname = $row[2];

		$tbl_parent=$row[4];
		$tbl_keywords=$row[5];
		$tbl_description=$row[6];
		$tbl_info=$row[7];
		
		$tbl_showmenu = $row[8];
		$tbl_position = $row[9];
        $editid = $row[0];
    }
}
//add new static page
if (isset($_POST['frm_name'])) {

	$frm_name=$_POST["frm_name"];
	$frm_parent=$_POST['frm_parent'];
	$frm_altname=$_POST['frm_altname'];
	$frm_keywords=$_POST['frm_keywords'];
	$frm_description=$_POST['frm_description'];
	$frm_info=$_POST['frm_info'];
	$frm_position=$_POST['frm_position'];
	$frm_showmenu=0;
	$qimage="";
	if($_FILES['frm_image']['error'] == 0){
	//var_dump($_FILES['frm_image']);
	//die();
		$ext=preg_match("!\.jpe?g$!is",$_FILES['frm_image']['name'],$match)?"jpg":"";
		$ext=preg_match("!\.gif$!is",$_FILES['frm_image']['name'],$match)?"gif":$ext;
		$ext=preg_match("!\.png$!is",$_FILES['frm_image']['name'],$match)?"png":$ext;
		move_uploaded_file($_FILES['frm_image']['tmp_name'], $HOSTPATH."/uploaded/menu/".$frm_altname.".".$ext);
		$qimage=",img='/uploaded/menu/".$frm_altname.".".$ext."'";
	}
	if($frm_parent==0){
		$level=1;
	} else {
		$res=mysql_query("select level from catalog_sections where id=".$frm_parent." limit 1");
		$row = mysql_fetch_row($res);
		$parent_level=$row[0];
		$level=$parent_level+1;
	}

	if ($_POST['frm_showmenu']) $frm_showmenu = 1;
    if (strlen($frm_name) >= 3) {
        if (!$_POST['editid']) {
            mysql_query("INSERT INTO catalog_sections SET name='$frm_name',altname='$frm_altname',level=$level,parent=$frm_parent, keywords='$frm_keywords',description='$frm_keywords',info='$frm_info',showmenu='$frm_showmenu',position='$frm_position'".$qimage);
        } else {
            mysql_query("UPDATE catalog_sections SET name='$frm_name',altname='$frm_altname',level=$level,parent=$frm_parent, keywords='$frm_keywords',description='$frm_keywords',info='$frm_info',showmenu='$frm_showmenu',position='$frm_position'".$qimage." WHERE id={$_POST['editid']}");
        }
        header("Location: ?component=catalog");
    } else echo "<b>Ошибка.</b> Минимальная длина названия - 3 символа";
}


/////////////////////

$res = mysql_query("SELECT MAX(level) FROM catalog_sections");
$row=mysql_fetch_row($res);
$max=$row[0];
$t="";
for($i=1;$i<=3;$i++){
	$t.="t$i.level AS level$i,t$i.id AS id$i,t$i.name AS name$i,t$i.altname AS alias$i,";
	if($i>1){
		$join.=" LEFT JOIN catalog_sections AS t$i ON t$i.parent = t".($i-1).".id";
	}
}
$t=substr($t,0,-1);
$query="SELECT ".$t." FROM catalog_sections as t1".$join." where t1.parent=0";
$res = mysql_query($query);
//$cols=4;
$options='';
$sections='';
while($row=mysql_fetch_row($res)){
	$str="---";
	if($row[0]==1){
		foreach($row as $num=>$val){
			if($val==NULL){
				break;
			}

			if($num%4==0){
				$otst=str_repeat($str, $val);
				$level=$val;
			}
			if($num%4==1){
				$flag=0;
				if(!in_array($val,$ar)){
					$selected=($val==$tbl_parent)?"selected":"";
					$options.="<option class=level$level value=$val $selected>";
					$link="<a href='?component=catalog&action=6&edit=$val'>[редактировать]</a> <a href='?component=catalog&action=6&del=$val'>[удалить]</a>";
					$ar[]=$val;
					$flag=1;
				}
			}
			if($num%4==2){
				if($flag==1){
					$options.=$otst.$val."</option>\n";
					$title=$val;
				}
			}
			if($num%4==3){
				if($flag==1){
					$sections.=$otst.$title. " (алиас - " .$val. ")".$link."<br />";
				}
			}

		}
		//echo count($row)."<br>";
	}
	//$id1=$row[1];
}

//$row[1] . " (в каталоге - " . $row[2] . ")"	. " <a href='?component=catalog&action=6&edit={$row[0]}'>[редактировать]</a> <a href='?component=catalog&action=6&del={$row[0]}'>[удалить]</a><br />";

/*
SELECT t1.name AS lev1, t2.name as lev2, t3.name as lev3, t4.name as lev4
FROM category AS t1
LEFT JOIN category AS t2 ON t2.parent = t1.category_id
LEFT JOIN category AS t3 ON t3.parent = t2.category_id
LEFT JOIN category AS t4 ON t4.parent = t3.category_id
WHERE t1.name = 'ELECTRONICS';
*/
//echo $query;
//die();



?>
<br><br>
<h1>Управление разделами каталога</h1>
<form method="post" enctype="multipart/form-data">
<table width="100%">
<tr>
<td width="130">Родитель:</td><td><select name=frm_parent>
<option value=0>корень</option>
<?php echo $options; ?>
</select></td>
</tr>
<tr>
<td width="130">Название:</td><td><input class="textbox" name="frm_name" type="text" style="width: 100%;" value="<?= $tbl_name ?>" required></td>
</tr>
<tr>
<td><b>Алиас:</b></td><td><input class="textbox" name="frm_altname" type="text" style="width: 100%;" value="<?= $tbl_altname ?>" required></td>
</tr>
<tr>
<td><b>Ключевые:</b></td><td><input class="textbox" name="frm_keywords" type="text" style="width: 100%;" value="<?= $tbl_keywords ?>"></td>
</tr>
<tr>
<td><b>Описание (description):</b></td><td><input class="textbox" name="frm_description" type="text" style="width: 100%;" value="<?= $tbl_description ?>"></td>
</tr>
<tr>
<td><b>Изображение:</b></td><td><input name="frm_image" type="file"></td>
</tr>
		<tr>
            <td colspan="2"><textarea name="frm_info" class="ckeditor" id="editor_ck"><?= $tbl_info ?></textarea></td>
        </tr>
<tr>
<td><b>Порядок:</b></td><td><input class="textbox" name="frm_position" type="text" style="width: 10%;" value="<?= $tbl_position ?>"></td>
</tr>
<tr>
<td>Показывать в меню:</td><td><input type="checkbox" name="frm_showmenu" <?php if ($tbl_showmenu) echo "checked"; ?>></td>
</tr>
<tr> 
<td colspan="2" align="right"><input type='hidden' name='editid' value='<?= $editid ?>'><input type="submit" class="button" value="Сохранить"></td>
</tr>
</table>
	<script type="text/javascript">//<![CDATA[
	window.CKEDITOR_BASEPATH='inc/ckeditor/';
	//]]></script>
	<script type="text/javascript" src="inc/ckeditor/ckeditor.js?t=B1GG4Z6"></script>
	<script type="text/javascript">//<![CDATA[
	CKEDITOR.replace('editor_ck', { "filebrowserBrowseUrl": "\/inc\/ckfinder\/ckfinder.html", "filebrowserImageBrowseUrl": "\/inc\/ckfinder\/ckfinder.html?type=Images", "filebrowserFlashBrowseUrl": "\/inc\/ckfinder\/ckfinder.html?type=Flash", "filebrowserUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Files", "filebrowserImageUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Images", "filebrowserFlashUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Flash" });
	//]]></script>
</form>
<!--
Обратите внимание на следующие особенности - альтернативное название не является обязательным, но если оно задано, то используется для отображения в каталоге. Обычное же название (полученное из прайс-листа в формате CSV) используется для синхронизации БД и CSV, а также для формирования ссылок.
-->
<br>
<br>
<h1>Существующие разделы</h1>
<?php

if ($sections == '') {
echo "Разделы не добавлены";
} else {
echo $sections;
}
?>
