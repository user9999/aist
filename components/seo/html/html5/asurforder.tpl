<script>
function money(){
	am=document.order.amount.value;
	wmoney=(Math.ceil(am/10*1.5))/100;
	rmoney=am/100*4;
	document.order.cash.value=wmoney;
	document.order.rcash.value=rmoney;
}
</script>
<h2>Покупка показов</h2>
<form method=post name=order>
<table>
<tr><td>Url сайта</td><td><input type=url name=url size=40 placeholder="http://"></td></tr>
<tr><td>Пароль для просмотра статистики</td><td><input size=40 name=pass></td></tr>
<tr><td>Количество показов</td><td><input name=amount size=6 onkeyup="money()"> сумма <input class=cash name=cash size=4 readonly> $ или <input name=rcash class=cash size=4 readonly> руб.</td></tr>
<tr><td></td><td><input type=submit name=surf value="Заказать"></td></tr>
</table>
</form>