<script>
function check_price(){
	if(document.order.price.value<3){
		alert('���� �� ����� ���� ���� 3-� ������ �� ����!');
	}
}
function count_symb(){
	cont=document.order.context.value;
	document.order.symb.value=150-cont.length;
	if(150-cont.length<1){
		alert('���������� �� ����� ���� ������� 150 ��������');
	}
}
function enable(){
	for (i=0;i<document.order.type.length;i++){
		if (document.order.type[i].checked==true){
			pref=document.order.type[i].value;
			break;
		}
	}
	if(pref==1){
		document.order.amountshow.disabled=false;
		document.order.amountshow.className='';
		document.order.amountshow.value='';
		document.order.amountclick.disabled=true;
		document.order.amountclick.className='cash';
		document.order.amountclick.value='';
		document.order.ccash.value='0';
		document.order.crcash.value='0';
		document.order.scash.value='0';
		document.order.srcash.value='0';
		document.order.price.disabled=true;
		document.order.price.value='';
		document.order.price.className='cash';
	}
	if(pref==2){
		document.order.amountshow.disabled=true;
		document.order.amountshow.className='cash';
		document.order.amountshow.value='';
		document.order.amountclick.disabled=false;
		document.order.price.disabled=false;
		document.order.price.value='3';
		document.order.price.className='';
		document.order.amountclick.className='';
		document.order.amountclick.value='';
		document.order.ccash.value='0';
		document.order.crcash.value='0';
		document.order.scash.value='0';
		document.order.srcash.value='0';
	}
}

function shmoney(){
	am=document.order.amountshow.value;
	wmoney=(Math.ceil(am/10*0.7))/100;
	rmoney=am/100*2;
	document.order.scash.value=wmoney;
	document.order.srcash.value=rmoney;
}
function clmoney(){
	del=Math.ceil(document.order.price.value*10)/10;
	am=document.order.amountclick.value;
	wmoney=(Math.ceil(am*del))/100;
	rmoney=(Math.ceil(am*del*26))/100;
	document.order.ccash.value=wmoney;
	document.order.crcash.value=rmoney;
}
</script>
<h2>����� ����������� �������</h2>
<!--warn-->
<form method=post name=order>
<table>
<tr><td>Url ����� ��� ��������</td><td><input type=url size=35 name=url value="http://"> ��������<input class=cash name=symb size=2 value=150 disabled> ����.</td></tr>
<tr><td>���������� ������(�������� 150 ��������)</td><td><textarea rows=3 cols=50 name=context onkeyup="count_symb()"></textarea></td></tr>
<tr><td>��� �������</td><td>������ <input type=radio name=type value=1 onclick="enable();"> �������� <input type=radio name=type value=2 onclick="enable();"></td></tr>
<tr><td>��������� ����� �� ����� 3 ������<br>(����� ���� ������� ����. 3.5 - ����� �����!)</td><td><input size=4 name=price onkeyup="clmoney()" onblur="check_price()" class=cash value="" disabled="disabled" /> �����</td></tr>
<tr><td>���������� ������� (������� 100)</td><td><input size=4 name=amountshow onkeyup="shmoney()" class=cash value="" disabled="disabled"> ����� <input class="cash" name=scash size=4 value=0 disabled> $ ��� <input name=srcash class=cash size=4 value=0 disabled> ���.</td></tr>
<tr><td>���������� ��������� (������� 10)</td><td><input size=4 name=amountclick onkeyup="clmoney()" class=cash value="" disabled="disabled"> ����� <input class="cash" name=ccash size=4 value=0 disabled> $ ��� <input name=crcash class=cash size=4 value=0 disabled> ���.</td></tr>
<tr><td>������ ��� ��������� ����������</td><td><input size=20 name=pass value=password></td></tr>
<tr><td></td><td><input type=submit name=addcont value="��������"></td></tr>
</table>
</form>