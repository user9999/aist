<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) {
    die("Access denied");
}
if ($_POST['edit']) {
    if ($_POST['id']) {
        $pos=(preg_match("!^[0-9]+$!", $_POST['pos'], $match))?$_POST['pos']:0;
        mysql_query('insert into '.$PREFIX.'farms set id="'.addslashes($_POST['id']).'",title="'.addslashes($_POST['tit']).'",description="'.addslashes($_POST['desc']).'",position='.$pos.',display='.$_POST['disp']);
    }
    if (is_array($_POST['bid'])) {
        foreach ($_POST['bid'] as $num=>$val) {
            $pos=(preg_match("!^[0-9]+$!", $_POST['position'][$val], $match))?$_POST['position'][$val]:0;
            mysql_query('update '.$PREFIX.'farms set title="'.addslashes($_POST['title'][$val]).'",description="'.addslashes($_POST['description'][$val]).'",position='.$pos.',display='.$_POST['display'][$val].' where id="'.$val.'"');
        }
    }
}

if ($_POST['del']) {
    mysql_query('update '.$PREFIX.'farms set display=0 where id="'.$_POST['del'].'"');
    mysql_query('delete from '.$PREFIX.'catalog_items where name like "'.$_POST['del'].'%"');
    mysql_query('delete from '.$PREFIX.'catalog_items2 where linked_item like "'.$_POST['del'].'%"');
}
 
$res=mysql_query('select * from '.$PREFIX.'farms order by display desc,position desc');
while ($row=mysql_fetch_row($res)) {
    if ($row[4]==1) {
        $options="<option value=0>не показывать</option><option value=1 selected>Показывать</option>";
        $tr="<tr>";
    } else {
        $options="<option value=0 selected>не показывать</option><option value=1>Показывать</option>";
        $tr="<tr class=hid>";
    }
    $out.=$tr."<td><input name='bid[]' style='width:40px' value='".$row[0]."' readonly></td><td><select name=display[".$row[0]."]>$options</select></td><td><input name='title[".$row[0]."]' value='".stripslashes($row[1])."'></td><td><textarea class=ckeditor id=\"editor_ck[".$row[0]."]\" name='description[".$row[0]."]'>".stripslashes($row[2])."</textarea></td><td><input name='position[".$row[0]."]' style='width:40px' value='".$row[3]."'></td><td><input class=\"del\" name=del value='".$row[0]."' type=submit></td></tr>";
}
?>
<form method=post>
<table>
<tr><td>ID</td><td></td><td>Заголовок</td><td>Описание</td><td>порядок</td><td>удалить</td></tr>
<tr><td><input style="width:40px" name=id></td><td><select name=disp><option value=0>не показывать</option><option value=1>Показывать</option></select></td><td><input name=tit></td><td><textarea name=desc class=ckeditor id="editor_ck[kvn_default]"></textarea></td><td><input name=pos style="width:40px"></td><td></td></tr>
<?php
echo $out;
?>
<tr><td></td><td></td><td></td><td><input type=submit name=edit value="Сохранить" class=button></td><td></td><td></td></tr>
</table>
</form>

