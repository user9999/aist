<script src="JsHttpRequest.js"></script>
<script type="text/javascript" language="JavaScript">
function doLoad(value) {
       	 var req = new JsHttpRequest();
       	req.onreadystatechange = function() {
        		if (req.readyState == 4) {

			
        		}
    	}
    	req.open(null, 'dorunlink.php', true);
    	req.send( { q: value } );
}
</script>
<h2 style="text-align:center">���������� ��������� �������</h2>

<table width="90%" border="0" cellspacing="2" cellpadding="0" align="center">
<form action="" method="post">
<tr>
<td width="150">���������� ������� (����������� 50):</td>
<td><input type="text" name="count" size="2" maxlength="2" value="5"></td>
<td rowspan="5"><p class="warn">���������</p><!--templates--></td>
</tr><tr>
<td>��� ������ ����� ������ (URL):</td>
<td><input type="text" name="enter" size="40" value="http://"></td>
</tr>
<tr>
<td>������ �������� ����� � ����� ������:</td>
<td>
<textarea cols="30" rows="5" name="keywords">
�������� ����� 1
�������� ����� 2
�������� ����� 3
</textarea>
</td>
</tr>
<tr><td colspan="2"><input type="submit" name="generate" value="������������"></td></tr>
</form>
</table>