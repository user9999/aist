<div class=content_body>
<h3><?php echo $TEMPLATE['title']?></h3>
<br>
<div style='float:right;font-weight:bold'>Вы заработали: <a href='<?php echo $PATH?>/account/witdraw'><?php echo $TEMPLATE['cash']?> руб.</a></div><br>
<?php echo $TEMPLATE['content']?>
<form method=post>
<table>
<tr><td colspan=2 style="text-align:center;font-size:16px;font-weight:bold">Смена пароля</td></tr>
<tr><td>Старый пароль</td><td><input type=password name=oldpass></td></tr>
<tr><td>Старый пароль еще раз</td><td><input type=password name=oldpass1></td></tr>
<tr><td>Новый пароль</td><td><input type=password name=pass></td></tr>
<tr><td></td><td><input type=submit name=password value="изменить"></td></tr>
</table>
</form>
</div>
