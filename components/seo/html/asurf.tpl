<script type="text/javascript" language="Javascript">
function aopen(){
	url=document.fasurf.asurf_site.value;
	window.open("-SITE_ADDR-asurf.php?asurf_site="+url,"asurf",'resizable=yes,menubar=0,location=1,scrollbars=1,status=1');
	//window.focus();
}
</script>
<h2>���������� ��������� �����</h2>
<table>
<form method="post" name="fasurf" onsubmit="return aopen();">
<tr><td>������� url ������ �����</td><td><input type="text" name="asurf_site" size="40" value="http://" /></td></tr>
<tr><td>������� ������ ��� ��������� ����������</td><td><input type="text" name="pass" size="40" value="" /></td></tr>
<tr><td></td><td><input type="submit" name="asurf" value="�������" /></td></tr>
</form>
</table>
<!--unauth_data-->
<p>��� ���� ����� �������� �� ���! ���������� ��������� ��������� ��� �� ���� � � ������� ��������� � ������ ����� �� ������ �������� 8%.
</p><p>���������� �������� ref_site (xxxxx) �� id ������ ����� � ��������� ����� ����������� �� ���� ����� �������������
</p>
<textarea style="margin-left:20px;font-size:10px;width:590px;height:240px">
<script type="text/javascript" language="Javascript">
function aopen(){
url=document.fasurf.asurf_site.value;
password=document.fasurf.pass.value;
window.open("-SITE_ADDR-asurf.php?asurf_site="+url+"&pass="+password+"&ref_site=xxxxx","asurf",'resizable=yes,menubar=0,location=1,scrollbars=1,status=1');
return false;	
}
</script>
<h2>���������� ��������� �����</h2>
<table>
<form method="post" name="fasurf" onsubmit="return aopen();">
<tr><td>������� url ������ �����</td><td><input type="text" name="asurf_site" size="40" value="http://" /></td></tr>
<tr><td>������� ������ ��� ��������� ����������</td><td><input type="text" name="pass" size="40" value="" /></td></tr>
<tr><td></td><td><input type="submit" name="asurf" value="�������" /></td></tr>
</form>
</table></textarea>