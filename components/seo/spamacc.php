<?php
//include_once("spam.php");
function acc(){
$enter="aenter";
$target['<!--logged-->']=$_SESSION['logged'];

$add=new mysql;
$add->connect();
$add->query_str="select id,name,email,url,content,amount,lastdate from spam where state='3' and id_user=".$_SESSION['id'];
$add->ms_query();
while($spams=mysql_fetch_row($add->query_result)){
	$target['<!--spams-->'].="<tr><td>".$spams[3]."</td><td>".$spams[2]."</td><td>".substr(stripslashes($spams[4]),0,40)."...</td><td><input type=\"submit\" name=\"red[".$spams[0]."]\" value=\"�������������\" class=\"little\" /><br /><input type=\"submit\" name=\"send[".$spams[0]."]\" value=\"���������\"  class=\"little\" /></td></tr>";
}
if($_POST['addspam']){
	$add->query_str="insert into spam values(NULL,".$_SESSION['id'].",'".addslashes($_POST['name'])."','".addslashes($_POST['email'])."','".addslashes($_POST['url'])."','".addslashes($_POST['content'])."','".$_POST['amount']."','0','".$_SESSION['pass']."',now(),'3')";
	$add->ms_query();
	$uid=mysql_insert_id();
	$add->ms_close();
	$target['<!--cod-->']="<script src=\"".$add->PATH_HTTP."cpartner.php?sid=".$uid."\"></script>";
	//$target['<!--warn-->']="<p class=\"warn\">�������� ���� ������ ��� ��������� ����������:</p><p class=\"warn\"> id �������� - ".$uid.";</p><p class=\"warn\"> ��� ������ - ".$_POST['pass'];
}
switch($_GET['act']){
		case "rules":
			$aspage="spamrules";
			break;
		case "ord":
			$aspage="spamorder";
			break;
		case "stat":
			$aspage="spamstat";
			break;
		case "free":
			$aspage="aspamfree";
			break;
		default:
			$aspage="spamrules";
			break;
}
if($_POST['statistics']){
	$add->query_str="select id,url,context,price,click,numshow,pass from context where id=".$_POST['id'];
	$add->ms_query();
	$passw=mysql_fetch_row($add->query_result);
	if(md5($_POST['pass'])===$passw[6]){
		$add->query_str="select click,ip,referer,date(visitdate),time(visitdate) from contextstat where id_context=".$_POST['id'];
		$add->ms_query();
		$amount=mysql_num_rows($add->query_result);
		$target['<!--stat-->']="<table class=\"banstat\"><caption style=\"margin:auto;\"><b>���� ������</b></caption><tr><td colspan=\"5\"><a href=\"".$passw[1]."\" target=\"_blank\">".stripslashes($passw[2])."</a><br />���� ����� - ".$passw[3]." �����<br />�������� ������ - ".$passw[4]."<br />�������� ��������� - ".$passw[5]."</td></tr>\n<tr><td>ip-�����</td><td>referer</td><td>����</td><td>�����</td><td>�������</td></tr>\n";
		while($stat=mysql_fetch_row($add->query_result)){
			if($stat[0]==1){
				$class=" class=\"marked\"";
				$disp="<b>+</b>";
				$num+=1;
			} else {
				$class="";
				$disp="";
			}
			$target['<!--stat-->'].="<tr".$class."><td>".$stat[1]."</td><td>".$stat[2]."</td><td>".$stat[3]."</td><td>".$stat[4]."</td><td>".$disp."</td></tr>\n";
		}
		$ctr=round((100/$amount*$num),2);
		$target['<!--ctr-->']=($ctr==0)?"":"<h3 style=\"text-align:center\" class=\"warn\">������� CTR - ".$ctr."%</h3>";
		$target['<!--stat-->'].="</table>";
	}
	$add->ms_close();
}
if($_POST['logout']){
	unset($_SESSION);
	session_destroy();
	$enter="fenter";
}

}
?>