<script>
function money(){
	am=document.order.amount.value;
	wmoney=(Math.ceil(am/10*1.5))/100;
	rmoney=am/100*4;
	document.order.cash.value=wmoney;
	document.order.rcash.value=rmoney;
}
</script>
<h2>Баннерная реклама</h2>
<!--warn-->
<form method=post name=order>
<table>
<tr><td>Адрес картинки</td><td><input type=url size=40 name=img placeholder="http://"></td></tr>
<tr><td>URL сайта</td><td><input type=url size=40 name=url placeholder="http://"></td></tr>
<tr><td>ALT-тэг (надпись всплывающая при наведении)</td><td><input size=40 name=alt></td></tr>
<tr><td colspan="2" style="text-align:center"><br />Стандартные размеры баннеров <b>468x60, 88x31, 100x100, 125x125</b> <br>
<b style="color:red">Для нестандартных размеров количество показов будет ограничено!</b><br><br>
</td></tr>
<tr><td>Ширина баннера(максимум 468)</td><td><input size=4 name=width></td></tr>
<tr><td>Высота баннера(максимум 125)</td><td><input size=4 name=height></td></tr>
<tr><td>Количество показов (минимум 100)</td><td><input size=4 name=amount onkeyup="money()">сумма <input class=cash name=cash size=4 readonly> $ или <input name=rcash class=cash size=4 readonly> руб.</td></tr>
<tr><td>Пароль для просмотра статистики</td><td><input size=20 name=pass></td></tr>
<tr><td></td><td><input type=submit name=addban value="Добавить"></td></tr>
</table>
</form>