<h2>Связь</h2>
<!--warn-->
<table>
<form method="post">
<tr><td>Ваше имя</td><td><input type="text" name="name" /></td></tr>
<tr><td>Ваш email</td><td><input type="text" name="email" /></td></tr>
<tr><td>Ваш id в системе (если зарегистрированы)</td><td><input type="text" name="uid" /></td></tr>
<tr><td colspan="2"><textarea name="letter" rows="5" cols="50"></textarea></td></tr>
<tr><td>Введите код с картинки</td><td>
<img src="captcha.php" alt="CAPTCHA"  style="float:left" />
<input type="text" name="code" size="12">
</td></tr>
<tr><td></td><td><input type="submit" name="send" value="отправить" /></td></tr>
</form>
</table>