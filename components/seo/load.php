<?php
require_once ('JsHttpRequest.class.php');
$JsHttpRequest =& new JsHttpRequest("windows-1251");
$data=explode("|",$_REQUEST['q']);
if((time()-$data[1])>=($data[2]-1)){
	$d=$data[4];
	$cr=$data[2]/20*0.75;
	$csh=$data[2]/20000;
	require_once('mysql.class.php');
	$asurf=new mysql;
	$asurf->connect();
	if(!isset($data[3]) || $data[3]==""){
 		$select_id="";
	} else {
		$select_id=" and id>".$data[3];
	}
	if($data[4]==0){
		$asurf->query_str="update asurf set credits=credits+".$cr." where id=".$data[0];
		$asurf->ms_query();
		if($data[5]!=0){
			$asurf->query_str="update asurf set credits=credits+".($cr*0.1)." where id=".$data[5];
			$asurf->ms_query();
		}
		$asurf->query_str="select id,url,duration from asurf where cash>0.001".$select_id." and id!=".$data[0]." limit 1";
		$asurf->ms_query();
		if(mysql_num_rows($asurf->query_result)){
			$site=mysql_fetch_row($asurf->query_result);
			$asurf->query_str="update asurf set cash=cash-".($site[2]/20000)." where id=".$site[0];
			$asurf->ms_query();
			$asurf->query_str="insert into asurfstat values(NULL,".$site[0].",2,'".$_SERVER['REMOTE_ADDR']."',now())";
			$asurf->ms_query();
//////////////////////////////
		} else {
			$d=1;
			$select_id=" and id>0";
		}
	}
	if($d==1){
		$asurf->query_str="update asurf set credits=credits+".$cr." where id=".$data[0];
		$asurf->ms_query();
		if($data[5]!=0){
			$asurf->query_str="update asurf set credits=credits+".($cr*0.1)." where id=".$data[5];
			$asurf->ms_query();
		}
		$asurf->query_str="select id,url,duration from asurf where credits>0.9".$select_id." and id!=".$data[0]." limit 1";
		$asurf->ms_query();
//$a=fopen("12.txt","a+");
//fwrite($a,$asurf->query_str."\r\n".$site[0]."\t".$site[1]."\t".$site[2]."\r\n".$data[0]."\r\n".$data[1]."\r\n".$data[2]."\r\n".$data[3]."\r\n");
//fclose($a);
		if(mysql_num_rows($asurf->query_result)){
			$site=mysql_fetch_row($asurf->query_result);
			$asurf->query_str="update asurf set credits=credits-".($site[2]/20)." where id=".$site[0];
			$asurf->ms_query();
			$asurf->query_str="insert into asurfstat values(NULL,".$site[0].",2,'".$_SERVER['REMOTE_ADDR']."',now())";
			$asurf->ms_query();
///////////////////////////////////
		} else {
			$site[0]=0;
			$site[1]=$asurf->PATH_HTTP."wait.php";
			$site[2]="300";
		}
	}
	$asurf->ms_close();
	$_RESULT[0]=$site[0];
	$_RESULT[1]=$site[1];
	$_RESULT[2]=$site[2];
	$_RESULT[3]=$d;
}
?>