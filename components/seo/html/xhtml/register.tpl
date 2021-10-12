<h2>Регистрация</h2>
<!--warn-->
<table>
<form method="post">
<tr><td>Ваше имя:</td><td><input type="text" name="name" /></td></tr>
<tr><td>Логин для входа в систему:</td><td><input type="text" name="name" /></td></tr>
<tr><td>Ваш email:</td><td><input type="text" name="mail" /></td></tr>
<tr><td>Z-кошелек Webmoney (не обязательно):</td><td><input type="text" name="wmz" value="Z" /></td></tr>
<tr><td>Пароль:</td><td><input type="password" name="pass" /></td></tr>
<tr><td>Повторить пароль:</td><td><input type="password" name="repass" /></td></tr>
<tr><td>Получать платные письма</td><td><input type="checkbox" name="receive" value="1" checked /></td></tr>
<tr><td>Введите код с картинки</td><td>
<img src="captcha.php" name="captcha" alt="captcha" />
<br />
<input type="text" name="code" size="8">
</td></tr>
<tr><td></td><td><input type="submit" name="submit" value="Зарегистрироваться" /></td></tr>
</form>
</table>