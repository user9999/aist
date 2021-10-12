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
<table>
<form method="post" name="order">
<tr><td>Url сайта</td><td><input type="text" name="url" size="40" value="http://" /></td></tr>
<tr><td>Пароль для просмотра статистики</td><td><input type="text" size="40" name="pass" value="" /></td></tr>
<tr><td>Количество показов</td><td><input type="text" name="amount" size="6" value="" onkeyup="money()" /> сумма <input type="text" class="cash" name="cash" size="4" value="" disabled /> $ или <input type="text" name="rcash" class="cash" size="4" value="" disabled  /> руб.</td></tr>
<tr><td></td><td><input type="submit" name="surf" value="Заказать" /></td></tr>
</form>
</table>