<script src="JsHttpRequest.js"></script>
<script>
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
<form method=post>
<table style="width:90%">
<tr>
<td style="width:150">���������� ������� (����������� 50):</td>
<td><input name=count size=2 maxlength=2 value=5></td>
</tr><tr>
<td>��� ������ ����� ������ (URL):</td>
<td><input type=url name=url size=40 placeholder="http://"></td>
</tr>
<tr>
<td>������ �������� ����� � ����� ������:</td>
<td>
<textarea cols=30 rows=5 name=keywords>
�������� ����� 1
�������� ����� 2
�������� ����� 3
</textarea>
</td>
</tr>
<tr><td colspan=2><input type=submit name=generate value="������������"></td></tr>
<tr><td colspan=2>���������<!--templates--></td></tr>
</table>
</form>