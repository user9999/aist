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
<script type="text/javascript" language="JavaScript">
function unlink(f){
	document.getElementById(f).src="tplstat.php?act=del&file="+f;
}
</script>

<script type="text/javascript" language="JavaScript">
function help(position){
	document.getElementById(position).style.display='block';
}
function hide(position){
	document.getElementById(position).style.display='none';
}
</script>
<script type="text/javascript">
var c=0; //������� ���������� �����
function addline()
{
	c++; // ����������� ������� �����
	s=document.getElementById('table').innerHTML; // �������� HTML-��� �������
	s=s.replace(/[\r\n]/g,''); // �������� ��� ������� �������� �����
	re=/(.*)(<tr id=.*>)(<\/table>)/gi; 
                // ��� ���������� ��������� ��������� �������� ��������� ������ �������
	s1=s.replace(re,'$2'); // �������� HTML-��� ��������� ������ �������
	s2=s1.replace(/\[\d+\]/gi,'['+c+']'); // �������� ��� ����� � ���������� �������
                // �� ����� ����� ������
	s2=s2.replace(/(rmline\()(\d+\))/gi,'$1'+c+')');
                // �������� �������� ������� rmline �� ����� ����� ������
	s=s.replace(re,'$1$2'+s2+'$3');
                // ������ HTML-��� � ����������� ����� ����� ������
	document.getElementById('table').innerHTML=s;
                // ���������� ��������� �� ����� �������� �������
	return false; // ����� �� ���������� ������� �� ������
}
function rmline(q)
{
                // if (c==0) return false; else c--;
                // ���� ����������������� ���������� �������, �� ��������� (������������) 
                // ������� ������� ����� ������.
	s=document.getElementById('table').innerHTML;
	s=s.replace(/[\r\n]/g,'');
	re=new RegExp('<tr id="?newline"? nomer="?\\['+q+'.*?<\\/tr>','gi');
                // ��� ���������� ��������� ��������� �������� ������ ������� � �������� �������
	s=s.replace(re,'');
                // �������� � �� ������ �����
	document.getElementById('table').innerHTML=s;
	return false;
}

</script>
<h2 style="text-align:center">��������� �������</h2>
<a href="replace.php" target="_blank">������������</a>

<div style="display:none;position:absolute;left:347px;top:274px;width:280px;height:90px;z-index:10;background:#f5f5f5;border:1px solid green;padding:2px 2px 2px 2px" id="picture" onMouseOver="help('picture');" onMouseOut="hide('picture');">
<b>� ������ ������������� ��������� ���������� ������������� ����� ���������� �� ���� ��� �������� ������� ������</b>
</div>
<div style="display:none;position:absolute;left:347px;top:244px;width:280px;height:90px;z-index:10;background:#f5f5f5;border:1px solid green;padding:2px 2px 2px 2px" id="dorurl" onMouseOver="help('dorurl');" onMouseOut="hide('dorurl');">
<b>������ � ������� ������������ ����� ������ ��� �������� � ������� HTML � ���������, ����� �� ���� ����� �������������� ������ �� ���� ����� � ��������� �������</b>
</div>
<p class="warn">��������� :</p><!--templates-->
<form action=""  enctype="multipart/form-data" method="post">
<div style="display:none;position:absolute;left:300px;top:900px;width:550px;height:180px;z-index:10;background:#f6f6f6;border:2px outset #ffffff;padding:5px 5px 5px 5px " id="gallery">


���������� �������� �����<input type="text" name="amt_pics"  class="light" /><br>
�� �������� <input type="text" name="rows" size="2" value="5" class="light" /> x <input type="text" name="cols" size="2" value="5" class="light"  />(� ������� - � ����)<br />
������ � �������� ������ � ����� ������ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ������ ������ (� ������ ���������)
<textarea name="redirect_url" rows="5" cols="30" class="light"></textarea><textarea name="false_url" rows="5" cols="30" class="light"></textarea>


<br/> <a href="#" onclick="document.getElementById('gallery').style.display='none'">�������</a>
</div>
<!--userfiles-->
<span id="table">
<table width="98%" cellspacing="2" cellpadding="2" align="center" border="1">
<tr id="newline" nomer="[0]"><td style="width:163px">�������� � ������� ����� ����� </td><td>
<input type="text" size="39" name="texturl[0]" value="http://" /> <a href="#" onclick="return addline();">�������� ����</a> | <a href="#" onclick="return rmline(0);">������ ����</a>
</td>
</tr>
</table>
</span>
<table width="98%" cellspacing="2" cellpadding="2" align="center" border="1">

<tr>
<td style="width:163px">���������� ������� :</td>
<td><input type="text" name="count" size="2" maxlength="3" value="5"></td>

</tr>
<tr>
<td>����:</td>
<td>
en<input type="radio" name="lang" value="en">
ru<input type="radio" name="lang" value="ru" checked>
</td>
</tr>
<tr>
<td>��� ������ ����� ������ (URL):</td>
<td><input type="text" name="upurl" size="40" value="http://"></td>
</tr>
<tr>
<td>���������� �������</td>
<td>
<input type="text" name="ext" value="html">
</td>
</tr>
<tr>
<td style="width:163px">������������ ��� � ������������ :</td>
<td><input type="checkbox" name="comments" value="1"></td>

</tr>
<tr>
<td style="width:163px">������������ RSS :</td>
<td><input type="checkbox" name="rss" value="1"></td>

</tr>
<tr>
<td style="width:163px">������������ google sitemap :<br><b>� ���� ������ ����������� ��������� ����� ��� ����� ���������� ������</b></td>
<td><input type="checkbox" name="google" value="1" onclick="if(this.checked==true){document.getElementById('dor').style.border='2px red inset';}else{document.getElementById('dor').style.border='2px inset #ffffff';}"></td>

</tr>
<tr>
<td><img src="./html/q.gif" alt="" style="float:right" onMouseOver="help('dorurl');" onMouseOut="hide('dorurl');" />����� ������ (�� ����):</td>
<td><input type="text" name="dorurl" size="40" value="http://" id="dor"></td>
</tr>
<tr>
<td><img src="./html/q.gif" alt="" style="float:right" onMouseOver="help('picture');" onMouseOut="hide('picture');" />�� ������������ js-��������:</td>
<td>
<input type="checkbox" name="js" value="1">
</td></tr>
<tr>
<td>������ �� ��������:</td>
<td>
0 <input type="radio" name="head" value="0" checked> 1 <input type="radio" name="head" value="1"> �� ���-�� keywords <input type="radio" name="head" value="key"> keywords+�������� <input type="radio" name="head" value="all">
</td>
</tr>
<tr>
<td>������������ ��������</td>
<td>
<input type="checkbox" name="translit" value="1" checked>
</td>
</tr>
<tr>
<td>������������ ������ � ���������</td>
<td>
<input type="checkbox" name="errors" value="1" checked>
</td>
</tr>
<tr>
<td>�������� �� ��������:</td>
<td>
0<input type="radio" name="picture" value="0"> &nbsp;&nbsp;&nbsp;&nbsp; 1<input type="radio" name="picture" value="1" checked>  &nbsp;&nbsp;&nbsp;&nbsp;�� ���-�� keywords<input type="radio" name="picture" value="2"> �������� <input type="radio" name="picture" value="3" onClick="help('gallery');" />
</td></tr>
<tr>
<td>�������� (������ photoshop jpg)</td>
<td>
<input type="FILE" name="userfile" size="16" style="float:left"> - ���� �� ������� ����� ������������ �����������
</td>
</tr>

<tr style="vertical-align:top">
<td>������������ ������ �� ������:<hr>
����� ������� ������ �� ����� � ������ �����, ������ - ����� ������<br>
���� �������� ���� � �� ������� �� ����� ������, ������ �������� ����� ����� ��������� �� ������
</td>
<td>
<input type="checkbox" name="uselink" value="1"><br>
<textarea cols="26" rows="7" name="links" style="float:left;padding-right:0"></textarea><textarea cols="26" rows="7" name="textlinks" style="float:right;padding-left:0"></textarea>

</textarea>
</td>
</tr>
<tr>
<td>������ �������� ����� ��� ��������� � ����� ������:<br>
���� �� ������ ������� �������� �� �������� ������ ��������� ������ �������, ����� ���������� ������� �� ����� ���������� �����
</td>
<td>
<textarea cols="35" rows="5" name="keywords">
�������� ����� 1
�������� ����� 2
�������� ����� 3</textarea>
</td>
</tr>
<tr>
<td>������� �����</td>
<td>
<input type="checkbox" name="hide_text" value="1">
</td>
</tr>

<tr>
<td>����� �� ����:</td>
<td>
<textarea cols="56" rows="8" name="text">

</textarea><br>

</td></tr>

</table>


<center><input type="submit" name="generate" value="������������"></center>
</form>

