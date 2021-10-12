<div class=content_body>
<h3><?php echo $TEMPLATE['title']?></h3>
<br>
<div style='float:right;font-weight:bold'>Вы заработали: <a href='<?php echo $PATH?>/account/witdraw'><?php echo $TEMPLATE['cash']?> руб.</a></div><br>
<p style='color:red'><?php echo $TEMPLATE['error']?></p>
<?php echo $TEMPLATE['content']?>
<?php
if($TEMPLATE['min']<$TEMPLATE['cash'] && !$TEMPLATE['confirm']) {
    ?>
<form method=post>
<table>
<tr><td>Сумма для вывода</td><td><input name=withdraw value="<?php echo $TEMPLATE['cash']?>"></td><td></td></tr>
<tr><td>Способ вывода</td><td><select name=where><?php echo $TEMPLATE['systems']?></select></td><td></td></tr>
<tr><td>Номер счета</td><td><input name=account></td><td>В случае вывода на телефон, необходимо указать оператора и номер, пример: <i>Билайн (906)1111111</i></td></tr>
<tr><td></td><td><input type=submit name=submit value='Заказать'></td></tr>
</table>
</form>
    <?php
} elseif($TEMPLATE['confirm']) {
    ?>
<form method=post>
<table>
<tr><td>Код подтверждения</td><td><input name=confirm></td></tr>
<tr><td></td><td><input type=submit name=code value='Подтвердить'></td></tr>
<tr><td colspan=2><br><br><input type=submit name=letter value='Выслать письмо повторно'></td></tr>
</table>
</form>
    <?php
} else {
    ?>
Вы еще не заработали минимальной суммы для вывода.
    <?php
}
?>
</div>
