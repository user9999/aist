<script>
function money(){
	am=document.order.amount.value;
	wmoney=(Math.ceil(am/10*1.5))/100;
	rmoney=am/100*4;
	document.order.cash.value=wmoney;
	document.order.rcash.value=rmoney;
}
</script>
<h2>������� �������</h2>
<table>
<form method="post" name="order">
<tr><td>Url �����</td><td><input type="text" name="url" size="40" value="http://" /></td></tr>
<tr><td>������ ��� ��������� ����������</td><td><input type="text" size="40" name="pass" value="" /></td></tr>
<tr><td>���������� �������</td><td><input type="text" name="amount" size="6" value="" onkeyup="money()" /> ����� <input type="text" class="cash" name="cash" size="4" value="" disabled /> $ ��� <input type="text" name="rcash" class="cash" size="4" value="" disabled  /> ���.</td></tr>
<tr><td></td><td><input type="submit" name="surf" value="��������" /></td></tr>
</form>
</table>