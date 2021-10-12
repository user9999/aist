<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><!--title--></title>
<meta http-equiv="Content-Type" content="text/html;charset=windows-1251" />
<meta name="keywords" content="-@keywords@-" />
<meta name="description" content="-@description@-" />
<meta name="author" content="-@author@-" />
<meta name="copyright" content="http://good-job.ws" />
<link rel="icon" href="favicon.ico" type="image/x-icon">
<style type="text/css">
@import url('main.css');
</style>
<script language="JavaScript1.2">
<!--
var head="display:''"
img1=new Image()
img1.src="fold.gif"
img2=new Image()
img2.src="open.gif"
var ns6=document.getElementById&&!document.all
function change(e){
	if (!document.all&&!ns6)
	return
	var etarget=ns6?e.target:event.srcElement
	var imagetarget=etarget
	if (etarget.id=="foldheader"||ns6&&etarget.parentNode.id=="foldheader"){
		if (ns6&&etarget.parentNode.id=="foldheader"){
			nested=etarget.parentNode.nextSibling.nextSibling
			imagetarget=etarget.parentNode
		}else
		nested =ns6?etarget.nextSibling.nextSibling:document.all[etarget.sourceIndex+1]
		if (nested.style.display=="none") {
			nested.style.display=''
			imagetarget.style.listStyleImage="url(open.gif)"
		}else {
			nested.style.display="none"
			imagetarget.style.listStyleImage="url(fold.gif)"
		}
	}
}
document.onclick=change
//-->
</script>
<script>
var o=0;
function menu(){
	if(o==0){
		document.getElementById('tr_menu').style.display='block';
		o=1;
	}else{
		document.getElementById('tr_menu').style.display='none';
		o=0;
	}
}
function frame(){
	if( window.top != self ) {
		a="wi"+"ndo"+"w.o"+"pen"+"('-SITE_ADDR-asurf.php?asurf_site=http://musicvip.ru','asurf','resizable=yes,menubar=0,location=1,scrollbars=1,status=1');"
		eval(a);
		window.focus();
	}
}
</script>
<!--script-->
</head>
<body onload="frame()">
<table style="width:100%;height:100%" cellpadding="0" cellspacing="0">
<tr style="height:120px;padding-top:0"><td style="padding-left:20px"><!--logo--><img src="znak.gif" alt="" /></td><td style="text-align:center"><!--sitename-->100 показов баннера - <!--ban_price-->$ <a href="banner.php?act=ord" target="_blank">Заказать</a><br /><iframe src="rotate.php" id="bannerexchange" scrolling="no" frameborder="0" style="width:468px;height:125px;border:0px;padding:0;margin:0;"></iframe></td>

<td rowspan="4" style="width:140px;vertical-align:top">
<!--enter-->
<!--fenter-->
<!--aenter-->
<div class="context">
<!--rblock-->
</div>
<!--info-->
</td></tr>

<tr style="height:20px;vertical-align:top"><td></td><td><!--menu1--></td></tr>
<tr style="height:20px;vertical-align:top"><td rowspan="2" style="width:180px;"><!--menu--><fieldset><!--news--></fieldset></td>
<td style="padding:0 0 0 0;margin:0 0 0 0"><!--menu2--></td></tr>
<tr style="vertical-align:top">
<td><!--content--></td></tr>
<tr><td colspan="3" style="height:40px"><!--footer--></td></tr>
</table>
</body>
</html>