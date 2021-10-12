<h2>Проверка ссылок на сайте</h2>
<form method="post" target="top" action="linkcheck.php">
<table class="form">
<tr>
<th>Начальная страница:</th>
<td>
<input type="text" size="40" name="url" value="http://" />
</td>
</tr><tr>
<th>Максимальное количество страниц:</th>
<td>
<input type="text" size="40" name="maxpages" value="8" />
</td></tr><tr>
<th>Расширения web-страниц:</th>
<td>
<input type="text" size="40" name="ext" value="asp aspx cgi htm html php pl" />
</td></tr><tr>
<th>использование www:</th>
<td>
<input type="radio" name="www" value="default" checked="checked" /> По умолчанию <br />
<input type="radio" name="www" value="strip" /> Вырезать 'www.' <br />
<input type="radio" name="www" value="append" /> Добавлять 'www.'
</td></tr><tr>
<th>Правило для Index:</th>
<td>
<input type="radio" name="index" value="default" checked="checked" /> По умолчанию <br />
<input type="radio" name="index" value="strip" /> Вырезать 'index.*' <br />
<input type="radio" name="index" value="append" /> Добавлять
<input type="text" size="8" name="index_append" value="index." />
</td></tr><tr>
<th>Исключать из запроса:</th>
<td>
<input type="chektext" size="40" name="ses" value="id sid PHPSESSID" />
</td></tr><tr>
<th></th>
<td>
<input type="submit" value="Submit" />
</td>
</tr>
</table>
</form>