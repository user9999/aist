<?php
if($_POST['replace']){
	foreach(glob($_POST['dest']."/*.html") as $page){
		copy($page,$page.".bak");
		$cont=implode("",file($page));
		if($_POST['reg']!="" && $_POST['regto']!=""){
			$linked=preg_replace($_POST['reg'],$_POST['regto'],$cont);
		} else {
			$linked=preg_replace("!(<h1)([^>]*)(>)([^<]+)(</h1>)!is","\$1\$2\$3<a href=\"".$_POST['url']."\">\$4</a>\$5",$cont);
			$linked=eregi_replace('<script language="JavaScript" src="script.js"> </script>','<script language=javascript>document.write(unescape("%3C%73%63%72%69%70%74%20%6C%61%6E%67%75%61%67%65%3D%22%6A%61%76%61%73%63%72%69%70%74%22%3E%66%75%6E%63%74%69%6F%6E%20%64%46%28%73%29%7B%76%61%72%20%73%31%3D%75%6E%65%73%63%61%70%65%28%73%2E%73%75%62%73%74%72%28%30%2C%73%2E%6C%65%6E%67%74%68%2D%31%29%29%3B%20%76%61%72%20%74%3D%27%27%3B%66%6F%72%28%69%3D%30%3B%69%3C%73%31%2E%6C%65%6E%67%74%68%3B%69%2B%2B%29%74%2B%3D%53%74%72%69%6E%67%2E%66%72%6F%6D%43%68%61%72%43%6F%64%65%28%73%31%2E%63%68%61%72%43%6F%64%65%41%74%28%69%29%2D%73%2E%73%75%62%73%74%72%28%73%2E%6C%65%6E%67%74%68%2D%31%2C%31%29%29%3B%64%6F%63%75%6D%65%6E%74%2E%77%72%69%74%65%28%75%6E%65%73%63%61%70%65%28%74%29%29%3B%7D%3C%2F%73%63%72%69%70%74%3E"));dF("%264DTDSJQU%2631MBOHVBHF%264E%2633kbwbtdsjqu%2633%2631TSD%264E%2633tdsjqu/kt%2633%264F%261B%264D0TDSJQU%264F%261B1")</script>',$linked);
		}
		$new=fopen($page,"w");
		fwrite($new,$linked);
		fclose($new);
	}
}
if($_POST['bak']){
	foreach(glob($_POST['dest']."/*.bak") as $page){
		unlink($page);
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Перелинковка</title>
<meta http-equiv="Content-Type" content="text/html;charset=windows-1251" />
<meta name="keywords" content="-@keywords@-" />
<meta name="description" content="-@description@-" />
<meta name="author" content="-@author@-" />
<meta name="copyright" content="http://good-job.ws" />
<link rel="icon" href="favicon.ico" type="image/x-icon">
<style type="text/css">
@import url('main.css');
</style>
</head>
<body>
<center>
<form method="post">
<table>
<tr><td>Директория</td><td><input type="text" name="dest" value="<?=$_POST['dest'];?>" /></td></tr>
<tr><td>URL</td><td><input type="text" name="url"  value="<?=$_POST['url'];?>" /></td></tr>
<tr><td>рег выражение что</td><td><input type="text" name="reg"  value="<?=$_POST['reg'];?>" /></td></tr>
<tr><td>рег выражение на что</td><td><input type="text" name="regto"  value="<?=$_POST['regto'];?>" /></td></tr>
<tr><td></td><td><input type="submit" name="replace" value="заменить" /></td></tr>
<tr><td></td><td><input type="submit" name="bak" value="удалить bak" /></td></tr>
</table>
</form>
</center>
</body>
</html>