<script>
function money(){
	am=document.order.amount.value;
	wmoney=(Math.ceil(am/10*3))/100;
	rmoney=am/100*80;
	document.order.cash.value=wmoney;
	document.order.rcash.value=rmoney;
}
</script>
<h2>����� �������� � ��������</h2>
<!--server-->
<!--warn-->
<p>������� ������, ������� �� ������ ��, ����� ���������� � ��������!</p>
<table>
<form method="post" name="order">
<tr><td>���� ��� ��� ���</td><td><input type="text" size="20" name="name" value="" /></td></tr>
<tr><td>����� (e-mail):</td><td><input type="text" size="20" name="email" value="" /></td></tr>
<tr><td>URL �����</td><td><input type="text" size="40" name="url" value="http://" /></td></tr>
<tr><td>URL �����</td><td><textarea name="content" rows="4" cols="45"></textarea></td></tr>
<tr><td>���������� ��������</td><td><input type="text" size="4" name="amount" onkeyup="money()" value="" />����� <input type="text" class="cash" name="cash" size="4" value="" disabled /> $ ��� <input type="text" name="rcash" class="cash" size="4" value="" disabled  /> ���.</td></tr>
<tr><td>������ ��� ��������� ����������</td><td><input type="text" size="20" name="pass" value="password" /></td></tr>
<tr><td></td><td><input type="submit" name="addspam" value="��������" /></td></tr>
</form>
</table>