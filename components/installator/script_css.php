<?php
$js="<script>
\$( document ).ready(function() {
	\$( \"#adminnum\" ).keyup(function() {
	num=\$(this).val();
	for(i=0;i<num;i++){
	\$( \"#adminmenus\" ).append('<label for=adminmenu['+i+']>Название подменю'+(i+1)+'</label><input type=text id=adminmenu['+i+'] name=adminmenu['+i+']><br>');
	\$( \"#adminmenus\" ).show(200);
	}
  
});
	\$( \"#usernum\" ).keyup(function() {
	num=\$(this).val();
	for(i=0;i<num;i++){
	\$( \"#usermenus\" ).append('<label for=usermenu['+i+']>Название подменю'+(i+1)+'</label><input type=text id=usermenu['+i+'] name=usermenu['+i+']><br>');
	\$( \"#usermenus\" ).show(200);
	}
  
});
	\$( \"#sitenum\" ).keyup(function() {
	num=\$(this).val();
	for(i=0;i<num;i++){
	\$( \"#sitemenus\" ).append('<label for=sitemenu['+i+']>Название подменю'+(i+1)+'</label><input type=text id=sitemenu['+i+'] name=sitemenu['+i+']><br>');
	\$( \"#sitemenus\" ).show(200);
	}
  
});

var num=1;
var tdone=new Array(1,1,1,1,1,1,1,1,1,1);
var tnum1=new Array(1,1,1,1,1,1,1,1,1,1);
$('#tabledata').on('keyup', '.tablefields', function() {
	
	elem=$(this).attr('id');
	tnum=elem.substr(11,1);
		tn=elem.substr(12);
	if(tn==(\"\")){ 
		tnum1[tnum]=1;
	} else {
		tnum1[tnum]=parseInt(tn)+1;
	}
	
	console.log(num,tnum1[tnum],tdone[tnum],tnum);
	if(tnum1[tnum]==tdone[tnum]){
		\$( \"#table\"+tnum ).append('<label for=\"tablefields'+tnum+''+tdone[tnum]+'\">Поле таблицы '+tnum+' '+tdone[tnum]+'<input id=\"tablefields'+tnum+''+tdone[tnum]+'\" class=tablefields name=tablefields['+tnum+']['+tdone[tnum]+'] type=text></label><div class=clear></div>');
		tdone[tnum]++;
	}
	num++;
});

	\$( \"#table\" ).keyup(function() {
	num=\$(this).val();
	for(i=1;i<=num;i++){
	\$( \"#tabledata\" ).append('".$langtable."<div class=tables id=table'+i+'><label for=tablename['+i+']><b>Название Таблицы '+i+'</b></label><input type=text id=tablename['+i+'] name=tablename['+i+'] required><br>'+
	'<label for=\"multi'+i+'\">Мультиязычность<input name=multi['+i+'] type=checkbox checked></label>'+
	'<label for=\"admindisplay'+i+'\">View в админке<input id=\"admindisplay'+i+'\" name=admindisplay['+i+'] type=checkbox checked></label>'+
	'<label for=\"sitedisplay'+i+'\">View на сайте<input id=\"sitedisplay'+i+'\" name=sitedisplay['+i+'] type=checkbox checked></label>'+
	'<label for=\"userdisplay'+i+'\">View в аккаунте<input id=\"userdisplay'+i+'\" name=userdisplay['+i+'] type=checkbox checked></label>'+
	'<label for=\"adminadd'+i+'\">Add в админке<input id=\"adminadd'+i+'\" name=adminadd['+i+'] type=checkbox checked></label>'+
	'<label for=\"siteadd'+i+'\">Add на сайте<input id=\"siteadd'+i+'\" name=siteadd['+i+'] type=checkbox></label>'+
	'<label for=\"useradd'+i+'\">Add в аккаунте<input id=\"useradd'+i+'\" name=useradd['+i+'] type=checkbox></label>'+
	'<label for=\"adminredact'+i+'\">Redact в админке<input id=\"adminredact'+i+'\" name=adminredact['+i+'] type=checkbox checked></label>'+
	'<label for=\"siteredact'+i+'\">Redact на сайте<input id=\"siteredact'+i+'\" name=siteredact['+i+'] type=checkbox></label>'+
	'<label for=\"userredact'+i+'\">Redact в аккаунте<input id=\"userredact'+i+'\" name=userredact['+i+'] type=checkbox></label><div class=clear></div>'+
	'<label style=\"width:900px\" for=\"tablefields'+i+'\">Поле таблицы '+i+' ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY )<input id=\"tablefields'+i+'\" class=tablefields name=tablefields['+i+'][0] type=text placeholder=\"\"></label><div class=clear></div>'+
	'<div>');
	\$( \"#tabledata\" ).show(200);
	}
  
});

});
</script>";
$css="
<style>
.langtable {
    width: 100%;
    text-align: center;
    font-weight: bold;
    font-size: 15px;
    color: #DC001D;
}
.labellang input{
float:right;
}
.tablefields{
width:400px;
}
label {
    min-width: 250px;
    display: block;
    float: left;
}
div.cmenu,div.tables {
    margin: 10px;
    border: 1px solid #555;
    padding: 10px;
    float: left;
    display: inline-block;
	border-radius: 10px;
}
div#adminmenus:before {
    content: \"Меню админа\";
    display: block;
    font-weight: bold;
    text-align: center;
    margin-bottom: 10px;
	    font-size: 15px;
    color: #DC001D;
}
div#usermenus:before {
    content: \"Меню пользователя\";
    display: block;
    font-weight: bold;
    text-align: center;
    margin-bottom: 10px;
	    font-size: 15px;
    color: #DC001D;
}
div.tables:before {
    content: \"Новая таблица\";
    display: block;
    font-weight: bold;
    text-align: center;
    margin-bottom: 10px;
	    font-size: 15px;
    color: #DC001D;
}
div#sitemenus:before {
    content: \"Меню на сайте\";
    display: block;
    font-weight: bold;
    text-align: center;
    margin-bottom: 10px;
	    font-size: 15px;
    color: #DC001D;
}
div#tabledata:before {
    content: \"Таблицы базы\";
    display: block;
    font-weight: bold;
    text-align: center;
    margin-bottom: 10px;
	    font-size: 15px;
    color: #DC001D;
}
.clear{clear:both}
</style>";
set_css($css);
set_script($js);
?>