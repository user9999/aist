<?php
header("Content-Type: text/html; charset=windows-1251");
require_once("page.class.php");
require_once("contdisplay.php");
require_once("session.class.php");
require_once("mysql.class.php");
//require
$session=new session;
if(!$session->session_true()){
	include_once("spamfront.php");
	
}
if($session->session_true()){
	include_once("spamacc.php");
	acc();
}
if($spam){///////////////////////////////////////�����������.......
	$ip=implode("",file(SECRET_DIR."remote"));
	require_once("ping.php");
	$time_conn = $HTTP_POST_VARS ["timeout"];
	$ping = new Net_Ping;
	$ping->ping($ip);
	$target['<!--server-->']="<p class=\"warn\">� ������ ������ ������ ����������, �������� �����, ��� ������ ������ ���������� ����� ������������� ����� ���������</p>";

	if ($ping->time){
		if($fp=@fopen("http://".$ip."/spammer/index.html","rb")){
			while(!feof($fp)) {
				$servcont .= fread($fp,4096);
			}
    			fclose($fp);
			if(eregi("spammer ready",$servcont)){
				$target['<!--server-->']="<p class=\"warn\">������ �������</p>";
			} else {
				$target['<!--server-->']="<p class=\"warn\">� ������ ������ ������ ����������, �������� �����, ��� ������ ������ ���������� ����� ������������� ����� ���������</p>";
			}
		} else {
			$target['<!--server-->']="<p class=\"warn\">� ������ ������ ������ ����������, �������� �����, ��� ������ ������ ���������� ����� ������������� ����� ���������</p>";
		}
	} else {
	$target['<!--server-->']="<p class=\"warn\">� ������ ������ ������ ����������, �������� �����, ��� ������ ������ ���������� ����� ������������� ����� ���������</p>";

	}
}
///////////////////////////////////////�����������.......
//target
$page=new page;
$context=new contdisplay;
$target['<!--rblock-->']=$context->display(10);
$target['<!--ban_price-->']=$page->ban_price;
$target['<!--title-->']="����������� �������";
$target['-@keywords@-']="����������� �������, �������, ������� ������ ��������";
$target['-@description@-']="��������� �������";
$target['-@author@-']="";
$cont=$page->replace_file("index.tpl","menu,".$enter.",menu1,menu2,footer,content#".$aspage,$target);
print $cont;
?>