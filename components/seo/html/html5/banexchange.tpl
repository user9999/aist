<script>
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
	document.order.cod.value='<iframe src="http://seo.musicvip.ru/rotate.php?bid='+id+netcod+'" name="bannerexchange" scrolling="no" frameborder="0" style="'+params+'border:0;padding:0;margin:0"></iframe>';
	return false;
}
</script>
<h2>Обмен показами баннеров</h2>
<form name="order">
<table border="1" style="text-align:center;width:100%">
<tr><td style="width:300px">id баннера на счет которого должны зачисляться показы</td><td><input type="text" name="id_ban" size="8" /></td></tr>
<tr><td>Сеть в которой вы хотите участвовать (фрейм размером этой сети будет необходимо установить на сайт)</td><td>468x60<input type="radio" name="id_net" value="468" /> | 88x31<input type="radio" name="id_net" value="88" /> | 100x100<input type="radio" name="id_net" value="100" /> | 125x125<input type="radio" name="id_net" value="125" /> | все <input type="radio" name="id_net" value="all" /></td></tr>
<tr><td></td><td><input type="button" name="bannet" value="получить код" onclick="return banner();"  /></td></tr>
<tr id="bantr"><td colspan="2"><textarea name="cod" cols="70" rows="5"></textarea></td></tr>
</table>
</form>
