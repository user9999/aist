<script>
function money(){
	am=document.order.amount.value;
	wmoney=(Math.ceil(am/10*3))/100;
	rmoney=am/100*80;
	document.order.cash.value=wmoney;
	document.order.rcash.value=rmoney;
}
</script>
<h2>Рассылка в гостевые бесплатно</h2>
<!--server-->
<!--warn-->
<table border="1"><caption>Ваши проекты</caption>
<form method="post" action="">
<tr><td>URL</td><td>email</td><td>Содержание</td><td>Действие</td></tr>
<!--spams-->
</form>
</table>

<p>Бесплатно вы можете разослать не более 20 сообщений.</p>
<p class="warn">Вводите данные, которые вы хотели бы, чтобы отражались в гостевых!</p>
<table>
<form method="post" name="order">
<tr><td>Ваше имя или ник</td><td><input type="text" size="20" name="name" value="" /></td></tr>
<tr><td>Адрес (e-mail):</td><td><input type="text" size="20" name="email" value="" /></td></tr>
<tr><td>URL сайта</td><td><input type="text" size="40" name="url" value="http://" /></td></tr>
<tr><td>Ваше сообщение</td><td><textarea name="content" rows="4" cols="45"></textarea></td></tr>
<tr><td>Количество гостевых</td><td><!--g_amount--></td></tr>
<tr><td></td><td><input type="submit" name="addspam" value="Добавить" /></td></tr>
</form>
</table>