<script>
function money(){
	am=document.order.amount.value;
	wmoney=(Math.ceil(am/10*1.5))/100;
	rmoney=am/100*4;
	document.order.cash.value=wmoney;
	document.order.rcash.value=rmoney;
}
</script>
<h2>��������� �������</h2>
<!--warn-->
<form method=post name=order>
<table>
<tr><td>����� ��������</td><td><input type=url size=40 name=img placeholder="http://"></td></tr>
<tr><td>URL �����</td><td><input type=url size=40 name=url placeholder="http://"></td></tr>
<tr><td>ALT-��� (������� ����������� ��� ���������)</td><td><input size=40 name=alt></td></tr>
<tr><td colspan="2" style="text-align:center"><br />����������� ������� �������� <b>468x60, 88x31, 100x100, 125x125</b> <br>
<b style="color:red">��� ������������� �������� ���������� ������� ����� ����������!</b><br><br>
</td></tr>
<tr><td>������ �������(�������� 468)</td><td><input size=4 name=width></td></tr>
<tr><td>������ �������(�������� 125)</td><td><input size=4 name=height></td></tr>
<tr><td>���������� ������� (������� 100)</td><td><input size=4 name=amount onkeyup="money()">����� <input class=cash name=cash size=4 readonly> $ ��� <input name=rcash class=cash size=4 readonly> ���.</td></tr>
<tr><td>������ ��� ��������� ����������</td><td><input size=20 name=pass></td></tr>
<tr><td></td><td><input type=submit name=addban value="��������"></td></tr>
</table>
</form>