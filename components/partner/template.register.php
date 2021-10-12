<div style="color:red">
<?php echo $TEMPLATE['error']?>
</div>
<br>
<form method=post>
<table>
<tr><td>Имя</td><td><input name=name value="<?php echo $TEMPLATE['name']?>"></td></tr>
<tr><td>Email</td><td><input name=email value="<?php echo $TEMPLATE['email']?>"></td></tr>
<tr><td>Пароль</td><td><input type=password name=pass></td></tr>
<tr><td>Подтверждение пароля</td><td><input type=password name=pass1></td></tr>
<tr><td>Получать новостную рассылку</td><td><input type=checkbox name=letters value=1 checked></td></tr>
<tr><td></td><td><input type=submit name=register value='Зарегистрироваться'></td></tr>
</table>
</form>
</div>
