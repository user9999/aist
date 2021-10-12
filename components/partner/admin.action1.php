<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
}
if($_POST['save']) {
    $tit=mysql_real_escape_string($_POST['title']);
    $rule=mysql_real_escape_string($_POST['frm_text']);
    mysql_query('update '.$PREFIX.'partner_rules set title="'.$tit.'",rule="'.$rule.'" where id=1');
}
$row=mysql_query('select title,rule from '.$PREFIX.'partner_rules where id=1');
$res=mysql_fetch_row($row);
$title=stripslashes($res[0]);
$content=stripslashes($res[1]);
$button="Сохранить";
?>
<br><br>
<h1>Правила</h1>
<form method=post>
<table>
<tr> 
<td align="left">Заголовок</td><td align=right><input name=title value="<?php echo $title?>" style="width: 100%;"></td>
</tr>
<tr>
<td colspan="2"><br>Содержание <br><textarea name=frm_text class=ckeditor id=editor_ck><?php echo $content ?></textarea></td>
</tr>
<tr> 
<td align="left"><br /><input type=submit name=save class=button value="<?php echo $button?>"></td><td align=right></td>
</tr>
</table>
</form>
