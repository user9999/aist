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
<form method=post name=order>
<table>
<tr><td>Url �����</td><td><input type=url name=url size=40 placeholder="http://"></td></tr>
<tr><td>������ ��� ��������� ����������</td><td><input size=40 name=pass></td></tr>
<tr><td>���������� �������</td><td><input name=amount size=6 onkeyup="money()"> ����� <input class=cash name=cash size=4 readonly> $ ��� <input name=rcash class=cash size=4 readonly> ���.</td></tr>
<tr><td></td><td><input type=submit name=surf value="��������"></td></tr>
</table>
</form>