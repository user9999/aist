<h2>�����������</h2>
<!--warn-->
<form method=post>
<table>
<!--<tr><td>���� ���:</td><td><input name=name></td></tr>-->
<tr><td>����� ��� ����� � �������:</td><td><input name=name pattern="[0-9a-zA-Z\._-]{4,50}" maxlength=50 required></td></tr>
<tr><td>��� email:</td><td><input type=email name=mail maxlength=126 required></td></tr>
<!--<tr><td>Z-������� Webmoney (�� �����������):</td><td><input name=wmz value=Z></td></tr>-->
<tr><td>������:</td><td><input type=password name=pass required></td></tr>
<tr><td>��������� ������:</td><td><input type=password name=repass required></td></tr>
<tr><td>�������� ������� ������</td><td><input type=checkbox name=receive value=1 checked></td></tr>
<tr><td>������� ��� � ��������</td><td>
<img src="captcha.php" name=captcha alt=captcha>
<br>
<input name=code size=8 required>
</td></tr>
<tr><td></td><td><input type=submit name=submit value="������������������"></td></tr>
</table>
</form>