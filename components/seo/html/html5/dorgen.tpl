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
var c=0; //счётчик количества строк
function addline()
{
	c++; // увеличиваем счётчик строк
	s=document.getElementById('table').innerHTML; // получаем HTML-код таблицы
	s=s.replace(/[\r\n]/g,''); // вырезаем все символы перевода строк
	re=/(.*)(<tr id=.*>)(<\/table>)/gi; 
                // это регулярное выражение позволяет выделить последнюю строку таблицы
	s1=s.replace(re,'$2'); // получаем HTML-код последней строки таблицы
	s2=s1.replace(/\[\d+\]/gi,'['+c+']'); // заменяем все цифры к квадратных скобках
                // на номер новой строки
	s2=s2.replace(/(rmline\()(\d+\))/gi,'$1'+c+')');
                // заменяем аргумент функции rmline на номер новой строки
	s=s.replace(re,'$1$2'+s2+'$3');
                // создаём HTML-код с добавленным кодом новой строки
	document.getElementById('table').innerHTML=s;
                // возвращаем результат на место исходной таблицы
	return false; // чтобы не происходил переход по ссылке
}
function rmline(q)
{
                // if (c==0) return false; else c--;
                // если раскомментировать предыдущую строчку, то последний (единственный) 
                // элемент удалить будет нельзя.
	s=document.getElementById('table').innerHTML;
	s=s.replace(/[\r\n]/g,'');
	re=new RegExp('<tr id="?newline"? nomer="?\\['+q+'.*?<\\/tr>','gi');
                // это регулярное выражение позволяет выделить строку таблицы с заданным номером
	s=s.replace(re,'');
                // заменяем её на пустое место
	document.getElementById('table').innerHTML=s;
	return false;
}

</script>
<h2 style="text-align:center">Генератор дорвеев</h2>
<a href="replace.php" target="_blank">перелинковка</a>

<div style="display:none;position:absolute;left:347px;top:274px;width:280px;height:90px;z-index:10;background:#f5f5f5;border:1px solid green;padding:2px 2px 2px 2px" id="picture" onMouseOver="help('picture');" onMouseOut="hide('picture');">
<b>В случае использования редиректа посетитель автоматически будет переброшен на сайт для которого пишется дорвей</b>
</div>
<div style="display:none;position:absolute;left:347px;top:244px;width:280px;height:90px;z-index:10;background:#f5f5f5;border:1px solid green;padding:2px 2px 2px 2px" id="dorurl" onMouseOver="help('dorurl');" onMouseOut="hide('dorurl');">
<b>Вместе с дорвеем генерируются листы ссылок для спамилки в формате HTML и текстовом, также на доре будут утанавливаться ссылки на свой адрес с ключевыми словами</b>
</div>
<p class="warn">Результат :</p><!--templates-->
<form action=""  enctype="multipart/form-data" method="post">
<div style="display:none;position:absolute;left:300px;top:900px;width:550px;height:180px;z-index:10;background:#f6f6f6;border:2px outset #ffffff;padding:5px 5px 5px 5px " id="gallery">


Количество картинок всего<input type="text" name="amt_pics"  class="light" /><br>
на странице <input type="text" name="rows" size="2" value="5" class="light" /> x <input type="text" name="cols" size="2" value="5" class="light"  />(в столбце - в ряду)<br />
ссылки с картинок каждая с новой строки &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ложные ссылки (в строке состояния)
<textarea name="redirect_url" rows="5" cols="30" class="light"></textarea><textarea name="false_url" rows="5" cols="30" class="light"></textarea>


<br/> <a href="#" onclick="document.getElementById('gallery').style.display='none'">закрыть</a>
</div>
<!--userfiles-->
<span id="table">
<table width="98%" cellspacing="2" cellpadding="2" align="center" border="1">
<tr id="newline" nomer="[0]"><td style="width:163px">страница с которой брать текст </td><td>
<input type="text" size="39" name="texturl[0]" value="http://" /> <a href="#" onclick="return addline();">Добавить поле</a> | <a href="#" onclick="return rmline(0);">Убрать поле</a>
</td>
</tr>
</table>
</span>
<table width="98%" cellspacing="2" cellpadding="2" align="center" border="1">

<tr>
<td style="width:163px">Количество страниц :</td>
<td><input type="text" name="count" size="2" maxlength="3" value="5"></td>

</tr>
<tr>
<td>Язык:</td>
<td>
en<input type="radio" name="lang" value="en">
ru<input type="radio" name="lang" value="ru" checked>
</td>
</tr>
<tr>
<td>Для какого сайта дорвей (URL):</td>
<td><input type="text" name="upurl" size="40" value="http://"></td>
</tr>
<tr>
<td>Расширение страниц</td>
<td>
<input type="text" name="ext" value="html">
</td>
</tr>
<tr>
<td style="width:163px">Использовать кеи в комментариях :</td>
<td><input type="checkbox" name="comments" value="1"></td>

</tr>
<tr>
<td style="width:163px">Использовать RSS :</td>
<td><input type="checkbox" name="rss" value="1"></td>

</tr>
<tr>
<td style="width:163px">Использовать google sitemap :<br><b>В этом случае обязательно указывать адрес где будет расположен дорвей</b></td>
<td><input type="checkbox" name="google" value="1" onclick="if(this.checked==true){document.getElementById('dor').style.border='2px red inset';}else{document.getElementById('dor').style.border='2px inset #ffffff';}"></td>

</tr>
<tr>
<td><img src="./html/q.gif" alt="" style="float:right" onMouseOver="help('dorurl');" onMouseOut="hide('dorurl');" />Адрес дорвея (не обяз):</td>
<td><input type="text" name="dorurl" size="40" value="http://" id="dor"></td>
</tr>
<tr>
<td><img src="./html/q.gif" alt="" style="float:right" onMouseOver="help('picture');" onMouseOut="hide('picture');" />Не использовать js-редирект:</td>
<td>
<input type="checkbox" name="js" value="1">
</td></tr>
<tr>
<td>ссылок на страницу:</td>
<td>
0 <input type="radio" name="head" value="0" checked> 1 <input type="radio" name="head" value="1"> по кол-ву keywords <input type="radio" name="head" value="key"> keywords+транслит <input type="radio" name="head" value="all">
</td>
</tr>
<tr>
<td>Использовать транслит</td>
<td>
<input type="checkbox" name="translit" value="1" checked>
</td>
</tr>
<tr>
<td>Использовать ошибки в раскладке</td>
<td>
<input type="checkbox" name="errors" value="1" checked>
</td>
</tr>
<tr>
<td>картинок на страницу:</td>
<td>
0<input type="radio" name="picture" value="0"> &nbsp;&nbsp;&nbsp;&nbsp; 1<input type="radio" name="picture" value="1" checked>  &nbsp;&nbsp;&nbsp;&nbsp;по кол-ву keywords<input type="radio" name="picture" value="2"> галлерея <input type="radio" name="picture" value="3" onClick="help('gallery');" />
</td></tr>
<tr>
<td>Картинка (только photoshop jpg)</td>
<td>
<input type="FILE" name="userfile" size="16" style="float:left"> - если не выбрать будет использована стандартная
</td>
</tr>

<tr style="vertical-align:top">
<td>Использовать ссылки по тексту:<hr>
Можно указать ссылки по одной в строке слева, справа - текст ссылки<br>
Если отметить бокс и не указать ни одной ссылки, каждое ключевое слово будет ссылаться на дорвей
</td>
<td>
<input type="checkbox" name="uselink" value="1"><br>
<textarea cols="26" rows="7" name="links" style="float:left;padding-right:0"></textarea><textarea cols="26" rows="7" name="textlinks" style="float:right;padding-left:0"></textarea>

</textarea>
</td>
</tr>
<tr>
<td>Каждое ключевое слово или выражение с новой строки:<br>
Если вы хотите разбить страницы по ключевым словам разделите пустой строкой, тогда количество страниц не менее количества групп
</td>
<td>
<textarea cols="35" rows="5" name="keywords">
Ключевое слово 1
Ключевое слово 2
Ключевое слово 3</textarea>
</td>
</tr>
<tr>
<td>Прятать текст</td>
<td>
<input type="checkbox" name="hide_text" value="1">
</td>
</tr>

<tr>
<td>Текст на тему:</td>
<td>
<textarea cols="56" rows="8" name="text">

</textarea><br>

</td></tr>

</table>


<center><input type="submit" name="generate" value="Генерировать"></center>
</form>

