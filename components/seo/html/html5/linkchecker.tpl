<h2>�������� ������ �� �����</h2>
<form method="post" target="top" action="linkcheck.php">
<table class="form">
<tr>
<th>��������� ��������:</th>
<td>
<input type="text" size="40" name="url" value="http://" />
</td>
</tr><tr>
<th>������������ ���������� �������:</th>
<td>
<input type="text" size="40" name="maxpages" value="8" />
</td></tr><tr>
<th>���������� web-�������:</th>
<td>
<input type="text" size="40" name="ext" value="asp aspx cgi htm html php pl" />
</td></tr><tr>
<th>������������� www:</th>
<td>
<input type="radio" name="www" value="default" checked="checked" /> �� ��������� <br />
<input type="radio" name="www" value="strip" /> �������� 'www.' <br />
<input type="radio" name="www" value="append" /> ��������� 'www.'
</td></tr><tr>
<th>������� ��� Index:</th>
<td>
<input type="radio" name="index" value="default" checked="checked" /> �� ��������� <br />
<input type="radio" name="index" value="strip" /> �������� 'index.*' <br />
<input type="radio" name="index" value="append" /> ���������
<input type="text" size="8" name="index_append" value="index." />
</td></tr><tr>
<th>��������� �� �������:</th>
<td>
<input type="chektext" size="40" name="ses" value="id sid PHPSESSID" />
</td></tr><tr>
<th></th>
<td>
<input type="submit" value="Submit" />
</td>
</tr>
</table>
</form>