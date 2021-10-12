<?php
session_start();
if (!isset($_SESSION['admin_name'])) die('--');
function xlsBOF() {
    $out=pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
    return $out;
}
function xlsEOF() {
    $out=pack("ss", 0x0A, 0x00);
    return $out;
}
function xlsWriteNumber($Row, $Col, $Value) {
    $out=pack("sssss", 0x203, 14, $Row, $Col, 0x0);
    $out.=pack("d", $Value);
    return $out;
}
function xlsWriteLabel($Row, $Col, $Value ) {
    $L = strlen($Value);
    $out=pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
    $out.=$Value;
    return $out;
}
require_once("inc/configuration.php");
require_once("inc/functions.php");
if($_GET['cmd']=='all'){
$out=xlsBOF();
$out.=xlsWriteLabel(0,0,"№");
$out.=xlsWriteLabel(0,1,"Дата");
$out.=xlsWriteLabel(0,2,"Время");
$out.=xlsWriteLabel(0,3,"Клиенты");
$out.=xlsWriteLabel(0,4,"Страница");
$out.=xlsWriteLabel(0,5,"Откуда");
$out.=xlsWriteLabel(0,6,"Запрос");

$i=1;
$res=mysql_query('select id,name,intime from visitors where browser not like "%bot%" and browser not like "%andex%" and browser not like "%spider%" and browser not like "%Mail.RU%" and browser not like "%crawler%" order by id');

while($row=mysql_fetch_row($res)){
	$i++;$pages='';$query='';$match=Array();$refer=Array();
	$res2=mysql_query('select page,refer,vtime from visits where uid='.$row[0]);
	
	while($row2=mysql_fetch_row($res2)){
		$refer[]=$row2[1];
		$pages.=$row2[0].";\n";
		$till=$row2[2];
	}
	
	$pages=substr($pages,0,-1);
	$query='';
    if(strstr($refer[0],'google') || strstr($refer[0],'mail.ru/search') || strstr($refer[0],'ask.com/web')){
      preg_match("!q=([^&]+)!",$refer[0],$match);
    } elseif(strstr($refer[0],'rambler.ru/search')){
      preg_match("!query=([^&]+)!",$refer[0],$match);
    } elseif(strstr($refer[0],'yandex.ru/')){
      preg_match("!text=([^&]+)!",$refer[0],$match);
    }
    $a=false;
    if(strpos($match[1],'%')!==false){
      $a=strpos($match[1],'%');
    }
    $query=urldecode($match[1]);
    if($a!==false && ord($query[$a+1])>191 && ord($query[$a+1])<256){
      //$query=iconv('windows-1251','utf-8',$query);
    } else {
      $query=iconv('utf-8','windows-1251',$query);
    }
     $spendtime=date("H:i:s",$row[2])." - ".date("H:i:s",$till);
   	$name=($row[1])?$row[1]:"";
   	
//echo $query;
   	//$o.=($i-1).";".date("d/m",$row[2]).";".$spendtime.";".$name.";".$pages.";".$refer[0].";".$query."\r\n";
$out.=xlsWriteNumber($i,0,$i-1);
$out.=xlsWriteLabel($i,1,date("d/m",$row[2]));
$out.=xlsWriteLabel($i,2,$spendtime);
$out.=xlsWriteLabel($i,3,iconv('utf-8','windows-1251',$name));
$out.=xlsWriteLabel($i,4,$pages);
$out.=xlsWriteLabel($i,5,$refer[0]);
$out.=xlsWriteLabel($i,6,$query);   
      
}
//die();
$out.=xlsEOF();

header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment;filename=".date("d.m",time()).".xls");
header("Content-Transfer-Encoding: binary ");
echo $out;


} elseif($_GET['url']){
   $gurl=urldecode($_GET['url']);
   $rep=Array('/',':','&','?','%','@','=');
   //$fname=parse_url($gurl);
   $fname=str_replace($rep,"",$gurl);
   $url=mysql_real_escape_string($gurl);
   $res=mysql_query('select a.id,a.uid,a.page,a.ip,a.refer,a.vtime,b.name,b.browser,b.intime from visits as a,visitors as b where refer like "%'.$_GET['url'].'%" and a.uid=b.id');
$out=xlsBOF();
$out.=xlsWriteLabel(0,0,"ID");
$out.=xlsWriteLabel(0,1,"Дата");
$out.=xlsWriteLabel(0,2,"Время");
$out.=xlsWriteLabel(0,3,"страницы");
$out.=xlsWriteLabel(0,4,"IP");
   $i=1;
   while($row=mysql_fetch_row($res)){
      $pages='';
      $res2=mysql_query('select page from visits where uid='.$row[1]);
      while($row2=mysql_fetch_row($res2)){
        $pages.=$row2[0].";\n";
      }
      $pages=substr($pages,0,-1);
      $name=($row[6])?$row[6]:$row[1];
       //echo '<tr><td>'.$name.'</td><td>'.date("d/m H:i:s",$row[8]).'</td><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[7].'</td></tr>';
$out.=xlsWriteLabel($i,0,$name);
$out.=xlsWriteLabel($i,1,date("d/m",$row[8]));
$out.=xlsWriteLabel($i,2,date("H:i:s",$row[8]));
$out.=xlsWriteLabel($i,3,$pages);
$out.=xlsWriteLabel($i,4,$row[3]);
      $i++;
   }
   
$out.=xlsEOF();
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment;filename=".$fname.'.'.date("d.m",time()).".xls");
header("Content-Transfer-Encoding: binary ");
echo $out;
}
?>