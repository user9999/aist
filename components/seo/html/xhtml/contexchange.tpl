<script language="javascript">
function count_symb(){
	cont=document.order.context.value;
	document.order.symb.value=150-cont.length;
	if(150-cont.length<1){
		alert('���������� �� ����� ���� ������� 150 ��������');
	}
}
function banner(){
	var net
	var params=''
	//document.getElementById('bantr').style.display='table-row';
	id=document.order.id_ban.value;
	for (i=0;i<document.order.id_net.length;i++){
		if (document.order.id_net[i].checked==true){
			net=document.order.id_net[i].value;
			break;
		}
	}
	if(net=='all'){
		netcod='';
	}else{
		netcod='&netid='+net;
		switch (net){
			case '468':
				params='width:468px;height:60px;';
				break;
			case '88':
				params='width:88px;height:31px;';
				break;
			case '100':
				params='width:100px;height:100px;';
				break;
			case '125':
				params='width:125px;height:125px;';
				break;
			case '468':
				params='';
				break;

		}
	}
	document.order.cod.value='<iframe src="http://localhost/frame/session/rotate.php?bid='+id+netcod+'" name="bannerexchange" scrolling="no" frameborder="0" style="'+params+'border:0;padding:0;margin:0"></iframe>';
	return false;
}
</script>
<h2>����� ����������� �������� (����� ��������).</h2>
<!--warn-->
<table border="1" width="100%">
<form name="order" method="post">
<tr><td>Url ����� ��� ��������</td><td><input type="text" size="35" name="url" value="http://" /> ��������<input type="text" class="cash" name="symb" size="2" value="150" disabled /> ����.</td></tr>
<tr><td>���������� ������(�������� 150 ��������)</td><td><textarea rows="3" cols="50" name="context" onkeyup="count_symb()"></textarea></td></tr>
<tr><td>������ ��� ��������� ����������</td><td><input type="text" size="20" name="pass" value="password" /></td></tr>
<tr><td></td><td><input type="submit" name="contexchange" value="��������" /></td></tr>
<tr style="text-align:center"><td colspan="2">
<p class="warn">��������� ��� ��� ����� ���������� �������� �� �������� ������� ���������� ������� �����</p>
<p class="warn">���� � ������� 5 ���� ������ �� ����� �������� �� ������ ���� ���� ������� ����� ������� �������������!</p>
<textarea name="cod" cols="70" rows="3"><!--cod--></textarea></td></tr>
</form>
</table>
