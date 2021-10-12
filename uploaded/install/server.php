<?php
if(!defined('INSTALL')) die();
$php=phpversion();
$phpnum=explode(".",$php);
if($phpnum[0]<4){
	$error="Допускается версия php От 4.0 до 5.4";
} elseif($phpnum[0]==5 && $phpnum[1]>4){
	$error="Допускается версия php От 4.0 до 5.4";	
} else {
	$error="";
}
if($error==""){
?>
<script> document.location.href='?step=2'</script>"
<?php
}
?>