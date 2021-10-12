<?php
require_once("browser.class.php");
require_once("session.class.php");
session_start();
if($_GET['url']){
	$asurf=new Browser;
	$asurf->addHeaderLine("Referer", "");
	$cont=implode("",$asurf->file($_GET['url']));
	if(!eregi("http-equiv=\"Refresh\"",$cont)){
		if(substr_count($_GET['url'],"/")>2){
			$site=preg_replace("'([^/]+)$'is","",$_GET['url']);
		} else {
			$site=$_GET['url']."/";
		}
		$cont=preg_replace("#href=['\"]?(?!(http://))(\.)?(/)?([^'^\"^\s]+)['\"\s]?#is","href=".$site."\$4 ",$cont);
		$cont=preg_replace("#src=['\"]?(?!(http://))(\.)?(/)?([^'^\"^\s]+)['\"\s]?#is","src=".$site."\$4 ",$cont);
		$cont=preg_replace("#url\(['\"]?(?!(http://))(\.)?(/)?([^'^\"^\s]+)['\"\)]?#is","url(".$site."\$4 ",$cont);
		print $cont;
	} else {
		print "<h3 style=\"text-align:center\">На данном сайте используется переадресация или блокировка фреймов. <br>В нашей системе он не может рекламироваться!</h3>";
	}
} else {
	print "<h3 style=\"text-align:center\">На данном сайте используется переадресация или блокировка фреймов. <br>В нашей системе он не может рекламироваться!</h3>";
}
?>
<script>

	if (top.location.href == self.location.href || window.top.location == document.location){
		top.location="asurf.php"

}
</script>