<h2>Связь</h2>
<!--warn-->
<form method=post>
<table>
<tr><td>Ваше имя</td><td><input name=name></td></tr>
<tr><td>Ваш email</td><td><input type=email name=email></td></tr>
<tr><td>Ваш id в системе (если зарегистрированы)</td><td><input name=uid></td></tr>
<tr><td colspan=2><textarea name=letter rows=5 cols=50></textarea></td></tr>
<tr><td>Введите код с картинки</td><td>
<img src="captcha.php" alt="CAPTCHA"  style="float:left">
<input name=code size=12>
</td></tr>
<tr><td></td><td><input type="submit" name="send" value="отправить"></td></tr>
</table>
</form>