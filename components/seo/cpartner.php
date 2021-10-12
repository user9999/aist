<?php
session_start();
if(is_numeric($_GET['sid'])){
	require_once("contdisplay.php");
	$data=new contdisplay;
	if($_SESSION['url']!=$_SERVER['REMOTE_ADDR']){
		$show=$data->display(7,$_GET['sid'],true);
		$_SESSION['url']=$_SERVER['REMOTE_ADDR'];
	} else {
		$show=$data->display(7,$_GET['sid'],false);
	}
	print "document.write('".$show."')";
}
?>