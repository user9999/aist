<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} ?>
<?php
if (isset($_GET['del'])) {
    mysql_query("DELETE FROM ".$PREFIX."menu WHERE id='{$_GET['del']}'");
    header("Location: ?component=menu"); 
}

if (isset($_GET['edit'])) {
    $res=mysql_query("SELECT * FROM ".$PREFIX."menu WHERE id='{$_GET['edit']}'");
    if ($row=mysql_fetch_row($res)) {
        $tbl_text=$row[1];
        $tbl_path=$row[2];
        $tbl_order=$row[3];
        $editid=$row[0];
    }
}

if (isset($_POST['frm_name']) && isset($_POST['frm_path'])) {
    $frm_name=$_POST['frm_name'];
    $frm_path=$_POST['frm_path'];
    $frm_order=$_POST['frm_order'];
    if (!$_POST['editid']) {
        mysql_query("INSERT INTO ".$PREFIX."menu SET text='$frm_name', path='$frm_path', ordering='$frm_order'");
    } else {
        mysql_query("UPDATE ".$PREFIX."menu SET text='$frm_name', path='$frm_path', ordering='$frm_order' WHERE id={$_POST['editid']}");
    }
    header("Location: ?component=menu");
}
?>

<h1>Меню</h1>
 
<form method="post">
    <table width="100%">
        <tr>
            <td width="120">Пункт меню:</td><td><input class="textbox" name="frm_name" type="text" size="50" value="<?php echo $tbl_text?>"></td>
        </tr>
        <tr>
            <td width="120">Путь:</td><td><input class="textbox" name="frm_path" type="text" size="50" value="<?php echo $tbl_path?>"></td>
        </tr>
        <tr>
            <td width="120">Порядок:</td><td><input class="textbox" name="frm_order" type="text" maxlength="1" size="10" value="<?php echo $tbl_order?>"></td>
        </tr>
        <tr>
            <td></td><td><input type='hidden' name='editid' value='<?php echo $editid?>'><input type="submit" class="button" value="Сохранить"></td>
        </tr>
    </table>
</form>
<br />
<br />
<h1>Существующие пункты меню</h1>
<?php
$res=mysql_query("SELECT * FROM ".$PREFIX."menu ORDER BY ordering, id");
$num=0;
while ($row=mysql_fetch_row($res)) {
    $num++;
    echo $row[1]." <a href='?component=menu&edit={$row[0]}'>[редактировать]</a> <a href='?component=menu&del={$row[0]}'>[удалить]</a><br />";
}
if ($num==0) { echo "Пункты не добавлены";
}
?>
