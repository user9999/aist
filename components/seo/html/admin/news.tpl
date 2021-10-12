<script language="JavaScript1.5">
function add(param){
	if(param=="ph_theme"){
		if(document.getElementById('sel_th').value!="no"){
			link_text=prompt("Введите текст ссылки","")
			a="<a href='photo.php?thid="+document.getElementById('sel_th').value+"' target=\"_blank\">"+link_text+"</a>"
			document.getElementById('content').value+=a
		}else{
		alert("вы не выбрали раздел!")
		}
	}
	if(param=="url"){
		link=prompt("введите URL с http:// (адрес ресурса в интернете)","http://")
		link_text=prompt("Введите текст ссылки","")
		a="<a href='"+link+"'; target=\"_blank\">"+link_text+"</a>"
		document.getElementById('content').value+=a
	}
	if(param=="b"){
		text=prompt("текст, который выделить жирно","")
		document.getElementById('content').value+="<b>"+text+"</b>"
	}
	if(param=="i"){
		text=prompt("текст, который выделить курсивом","")
		document.getElementById('content').value+="<i>"+text+"</i>"
	}
	if(param=="h"){
		text=prompt("Введите подзаголовок","")
		document.getElementById('content').value+="<h3>"+text+"</h3>"
	}
	if(param=="imgl"){
		if(document.getElementById('sel_th').value!="no"){
			img=document.getElementById('sel_ph').value
			document.getElementById('content').value+="<img src=\"photo/thumb/"+img+"\" style=\"float:left\" />"
		}else{
			alert("вы не выбрали фото!")
		}	
	}
	if(param=="imgr"){
		if(document.getElementById('sel_th').value!="no"){
			img=document.getElementById('sel_ph').value
			document.getElementById('content').value+="<img src=\"photo/thumb/"+img+"\" style=\"float:right\" />"
		}else{
			alert("вы не выбрали фото!")
		}		
	}
	if(param=="img_link"){
		if(document.getElementById('sel_th').value!="no"){
			text=prompt("текст, Для ссылки на фото","")
			img=document.getElementById('sel_ph').value
			document.getElementById('content').value+="<a href=\"#\" onclick=\"window.open('photo/pics/"+img+"','"+img+"')\">"+text+"</a> "
		}else{
			alert("вы не выбрали фото!")
		}		
	}
}
</script>
<h3>Новости сайта</h3>
<!--warn-->
<table style="float:left">
<form method="post" action="">
<tr><td colspan="2">Название</td><td colspan="6"><input type="text" name="title" size="53" maxlength="64" --ntitle-- /></td></tr>
<tr><td colspan="2">Краткое описание</td><td colspan="6"><textarea name="brief" rows="3" cols="40"><!--brief--></textarea></td></tr>
<tr><td><a href="#" class="menu" style="width:50px" title="вставить картинку слева по тексту" onclick="add('imgl')">img-L</a></td><td><a href="#" class="menu" style="width:50px" title="вставить картинку справа по тексту" onclick="add('imgr')">img-R</a></td>
<td><a href="#" class="menu" style="width:50px" title="вставить ссылку на свою картинку" onclick="add('img_link')">img link</a></td><td>
<a href="#" class="menu" style="width:50px" title="ссылка на раздел фото" onclick="add('ph_theme')">theme</a></td><td>
<a href="#" class="menu" style="width:50px" title="ссылка на внешний ресурс" onclick="add('url')">url</a></td><td>
<a href="#" class="menu" style="width:50px;font-weight:bold" title="Выделить жирным" onclick="add('b')">B</a></td><td><a href="#" class="menu" style="width:50px;font-style:italic" title="выделить курсивом" onclick="add('i')">I</a></td><td>
<a href="#" class="menu" style="width:50px" title="Подзаголовок" onclick="add('h')">Сhapter</a>
</td></tr>
<tr><td colspan="2">Полное описание<br />
<select name="sel_th" id="sel_th" onchange="doLoad(this.value)">
<option value="no">выбрать</option>
<!--sel_theme-->
</select><br />
<select name="sel_ph" id="sel_ph">
<option value="no">выбрать</option>
<!--sel_photo-->
</select>


</td>



<td colspan="6"><textarea name="full" rows="15" cols="40" id="content"><!--full--></textarea></td></tr>
<tr><td colspan="2"><input type="hidden" name="id" --value-- /></td><td colspan="6"><input type="submit" name="news" value="Добавить/редактировать"/></td></tr>

</form>
</table>
<table border="1" style="align:right;height:100%;border-left:groove black 4px">
<form method="post" action="">
<tr style="height:15px"><td>дата</td><td>посмотреть</td><td>редактировать</td><td>Архивация</td></tr>
<!--all-->
<tr><td colspan="2"><input type="submit" name="ar" value="Архивировать" /></td><td colspan="2"><input type="submit" name="ard" value="Архивир-ть и удалить" /></td></tr>
</form>
</table>
<div id="debug">
</div>