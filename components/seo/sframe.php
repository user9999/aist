<?php
session_start();
require_once("vars.class.php");
$vars=new vars;
if(!$_GET['tm']){
	$surf_time=20;
	$begin_time=time();
	//print $begin_time;
	$id=$_GET['id'];
}
if($_GET['ref_site']){
	$ref_site=$_GET['ref_site'];
} else {
	$ref_site=0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>aframe</title>
<meta http-equiv="Content-Type" content="text/html;charset=windows-1251" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="copyright" content="" />
<style type="text/css">
@import url('http://localhost/frame/session/main.css');
</style>
<script src="JsHttpRequest.js"></script>
<script type="text/javascript" language="JavaScript">
var ref_site=<?=$ref_site;?>;
var take=0;
var begin=1;
var imf="<?=$_GET['url'];?>";
var a=<?=$surf_time;?>;
if(!a){
	a=20;
}
function doLoad(value) {
        var req = new JsHttpRequest();
       	req.onreadystatechange = function() {
        	if (req.readyState == 4) {
			window.parent.ago.location.href="ago.php?url="+req.responseJS[1];
			a=req.responseJS[2];
			begin=req.responseJS[0];
			imf=req.responseJS[1];
			take=req.responseJS[3];
        	}
    	}

    	req.open(null, 'load.php', true);
    	req.send( { q: value } );
}
var counter=1+parseInt(a);
var paused=0;
function start_time(){do_count();} 
function do_count(){
	if(paused==0){counter--;}
	if(counter>=0){
		document.ftime.time.value=counter;
		setTimeout("do_count()",1000);
	}
	if(counter==0){
		doLoad("<?=$id."|".$begin_time."|";?>"+a+"|"+begin+"|"+take+"|"+ref_site);
	}
	if(counter<0){
		counter=1+parseInt(a);
		do_count();
		//document.f.submit();
	}
}
function pause_time(){
	paused=1-paused;
	if(paused==1){
		document.getElementById('stop').innerHTML='Продолжить';
	} else {
		document.getElementById('stop').innerHTML='Остановить';
	}
	return false;
}
function open_w(){window.open(imf);return false;}

function restore(){
		window.parent.location.href="asurf.php";
		window.self.location.href="aframe.php";
		window.parent.ago.location.href="ago.php";
}
</script>
</head>
<body onload="do_count();" onBeforeUnload="restore();">
<table class="asurf" cellpadding="0" cellspacing="0" width="100%">
<tr><td style="width:300px;height:60px;background:#dddddd">
<form name="ftime">
<input type="text" name="time" size="2" class="disable" /><div onclick="pause_time();" id="stop" class="disable" onMouseOver="this.style.color='red';" onMouseOut="this.style.color='black';">Остановить</div><br />
</form>
<div onclick="open_w();" class="disable" style="padding-left:10px;margin-left:0px;" onMouseOver="this.style.color='red';" onMouseOut="this.style.color='black';">В новом окне</div>
</td><td style="text-align:right">100 показов баннера - <?=$vars->ban_price;?>$ <a href="ban_order.php" target="_blank">Заказать</a><br /><iframe src="rotate.php" name="bannerexchange" scrolling="no" frameborder="0" style="width:468px;height:60px;border:0px;padding:0;margin:0"></iframe></td></tr>
<tr><td colspan="2"></td></tr>
</table>
</body>
</html>