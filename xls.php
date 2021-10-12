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
$trends=array("","Оптика","Кузовные запчасти","Аксессуары");
if(isset($_GET['order_id'])){
	$order_id = (int) $_GET['order_id'];
  $out=xlsBOF(); //начинаем собирать файл
$out.=xlsWriteLabel(0,0,"№");
$out.=xlsWriteLabel(0,1,"Дата");
$out.=xlsWriteLabel(0,2,"Время");
$out.=xlsWriteLabel(0,3,"ID Груз-Зап");
$out.=xlsWriteLabel(0,4,"ОЕМ");
$out.=xlsWriteLabel(0,5,"ID Произв-ля");
$out.=xlsWriteLabel(0,6,"Марка");
$out.=xlsWriteLabel(0,7,"Модель");
$out.=xlsWriteLabel(0,8,"Наименование");
$out.=xlsWriteLabel(0,9,"Направление");
$out.=xlsWriteLabel(0,10,"Производитель");
$out.=xlsWriteLabel(0,11,"Кол-во");
$out.=xlsWriteLabel(0,12,"Цена");
$out.=xlsWriteLabel(0,13,"Сумма");
$out.=xlsWriteLabel(0,14,"Акция");
$out.=xlsWriteLabel(0,15,"Фирма");
$out.=xlsWriteLabel(0,16,"ФИО");
$out.=xlsWriteLabel(0,17,"тип клиента");
$out.=xlsWriteLabel(0,18,"Скидка(%)");
$out.=xlsWriteLabel(0,19,"Тел");
$out.=xlsWriteLabel(0,20,"E-mail");
	$res=mysql_query("SELECT * FROM orders WHERE id = $order_id");
	if($row=mysql_fetch_array($res)){
    if($row['currency']!=''){
      $cur=($row['currency']=='euro')?"евро":"долларах";
      $out.=xlsWriteLabel(0,21,"Цена в $cur");
      $out.=xlsWriteLabel(0,22,"Сумма в $cur");
      $out.=xlsWriteLabel(0,23,"Курс");
      $out.=xlsWriteLabel(0,24,"Коэффициент");
    }
	  $odate=date("d.m.Y", $row['date']);
	  $otime=date("H:i", $row['date']);
    $uname=$row['name'];
    $phone=$row['phone'];
    $email=$row['email'];
		if($row['utype']!=0){
      $res3 = mysql_query("SELECT * FROM users WHERE id = '".$row['user_id']."' limit 1");
      $row3 = mysql_fetch_array($res3);
      if($row3['actype'][0]==1){
        $client="прайс-лист";
      } elseif($row3['actype'][1]==1){
        $client="накопительный %";      
      } else {
        $client="индивидуальный %";
      }
      $trend_purc=unserialize($row3['trend_purc']);
      $company=$row3['company'];
      $uname=$row3['name'];
      $phone=str_replace("\r\n"," ",$row3['udata']);
      $email=$row3['email'];
		}
		$res2 = mysql_query("SELECT a.*,b.section,b.country FROM orders_items as a,catalog_items as b WHERE a.name=b.name and a.orders_id = {$row[0]} order by  b.country,b.section,b.brand_id,b.model_id,b.description");
    $num=0;
		while($row2 = @mysql_fetch_array($res2)){
		  $percent=$row3['percent'];
      $num++;
		  $action=$row2['action'];
		  $amount=$row2['quantity'];
      $price=$row2['price'];
      $sum=$price*$amount;
      $estr=$eprice=$esum="";
      if($row['currency']!=''){
        $price=floor($row2['price']*$row['exrate']*$row['ratio']);
        $eprice=$row2['price'];
        $esum=$eprice*$amount;
        $estr=";".$eprice.";".$esum.";".$row['exrate'].";".$row['ratio'];
        $sum=$price*$amount;
        $allesum+=$esum;
      }
      $amt+=$amount;
      $allsum+=$sum;
      if($trend_purc[$row2['country']."_".$row2['section']]){
        $percent=$trend_purc[$row2['country']."_".$row2['section']];
      }
      $res4 = mysql_query("SELECT a.*,b.name as bname,c.name as cname FROM catalog_items AS a, catalog_brands AS b, catalog_models AS c WHERE a.name = '".$row2['name']."' AND a.model_id=c.id AND a.brand_id=b.id limit 1");
      $row4 = mysql_fetch_array($res4);
		  $idgruzzap=$row2['name'];
      $oem=$row4['oem'];
      $brand=$row4['bname'];//марка
      $model=$row4['cname'];
      $name=$row4['description'];
      $country=$row4['country'];
      $trend=$trends[$row4['section']];
      $manufacturer=$row4['provider'];
$out.=xlsWriteNumber($num,0,$num);
$out.=xlsWriteLabel($num,1,iconv("utf-8","windows-1251",$odate));
$out.=xlsWriteLabel($num,2,iconv("utf-8","windows-1251",$otime));
$out.=xlsWriteLabel($num,3,iconv("utf-8","windows-1251",$idgruzzap));
$out.=xlsWriteNumber($num,4,$oem);
$out.=xlsWriteLabel($num,5,iconv("utf-8","windows-1251",$manufacturer));
$out.=xlsWriteLabel($num,6,iconv("utf-8","windows-1251",$brand));
$out.=xlsWriteLabel($num,7,iconv("utf-8","windows-1251",$model));
$out.=xlsWriteLabel($num,8,iconv("utf-8","windows-1251",$name));
$out.=xlsWriteLabel($num,9,$trend);
$out.=xlsWriteLabel($num,10,iconv("utf-8","windows-1251",$country));
$out.=xlsWriteNumber($num,11,$amount);
$out.=xlsWriteNumber($num,12,$price);
$out.=xlsWriteNumber($num,13,$sum);
$out.=xlsWriteLabel($num,14,iconv("utf-8","windows-1251",$action));
$out.=xlsWriteLabel($num,15,iconv("utf-8","windows-1251",$company));
$out.=xlsWriteLabel($num,16,iconv("utf-8","windows-1251",$uname));
$out.=xlsWriteLabel($num,17,$client);
$out.=xlsWriteLabel($num,18,iconv("utf-8","windows-1251",$percent));
$out.=xlsWriteLabel($num,19,iconv("utf-8","windows-1251",$phone));
$out.=xlsWriteLabel($num,20,iconv("utf-8","windows-1251",$email));
      if($row['currency']!=''){
$out.=xlsWriteNumber($num,21,$eprice);
$out.=xlsWriteNumber($num,22,$esum);
$out.=xlsWriteNumber($num,23,$row['exrate']);
$out.=xlsWriteNumber($num,24,$row['ratio']);
      }
		}
	}
  $out.=xlsWriteLabel($num+2,11,"ШТУК");
  $out.=xlsWriteNumber($num+2,12,$amt);
  $out.=xlsWriteLabel($num+2,13,"СУММА");
  $out.=xlsWriteNumber($num+2,14,$allsum);
  $out.=xlsWriteNumber($num+2,22,$allesum);
$out.=xlsEOF();
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment;filename=$order_id.xls");
header("Content-Transfer-Encoding: binary ");
echo $out;
} elseif(isset($_GET['preorder_id'])){
  $order_id = (int) $_GET['preorder_id'];
  $out=xlsBOF(); //начинаем собирать файл
$out.=xlsWriteLabel(0,0,"№");
$out.=xlsWriteLabel(0,1,"Дата");
$out.=xlsWriteLabel(0,2,"Время");
$out.=xlsWriteLabel(0,3,"ID Груз-Зап");
$out.=xlsWriteLabel(0,4,"ОЕМ");
$out.=xlsWriteLabel(0,5,"ID Произв-ля");
$out.=xlsWriteLabel(0,6,"Марка");
$out.=xlsWriteLabel(0,7,"Модель");
$out.=xlsWriteLabel(0,8,"Наименование");
$out.=xlsWriteLabel(0,9,"Направление");
$out.=xlsWriteLabel(0,10,"Производитель");
$out.=xlsWriteLabel(0,11,"Кол-во");
$out.=xlsWriteLabel(0,12,"Цена");
$out.=xlsWriteLabel(0,13,"Сумма");
$out.=xlsWriteLabel(0,14,"Акция");
$out.=xlsWriteLabel(0,15,"Фирма");
$out.=xlsWriteLabel(0,16,"ФИО");
$out.=xlsWriteLabel(0,17,"тип клиента");
$out.=xlsWriteLabel(0,18,"Скидка(%)");
$out.=xlsWriteLabel(0,19,"Тел");
$out.=xlsWriteLabel(0,20,"E-mail");
	$res = mysql_query("SELECT a.*,b.name,b.email,b.company,b.actype,b.percent,b.udata,b.trend_purc FROM preorder_admin as a,users as b WHERE a.user_id=b.id and a.id = $order_id");
	$num=0;
	if ($row = mysql_fetch_array($res)) {
	  if($row['currency']!=''){
      $cur=($row['currency']=='euro')?"евро":"долларах";
      //$out.="Цена в $cur;Сумма в $cur;Курс;Коэффициент;\r\n";
      $out.=xlsWriteLabel(0,21,"Цена в $cur");
      $out.=xlsWriteLabel(0,22,"Сумма в $cur");
      $out.=xlsWriteLabel(0,23,"Курс");
      $out.=xlsWriteLabel(0,24,"Коэффициент");
    } else {
      //$out.="\r\n";
    }
	  $odate=date("d.m.Y", $row['order_date']);
	  $otime=date("H:i", $row['order_date']);
    $uname=$row['name'];
    $phone="";$row['phone'];
    $email=$row['email'];
    
    $company=$row['company'];
    $phone=str_replace("\r\n"," ",$row['udata']);
    
    if($row['actype'][0]==1){
        $client="прайс-лист";
    } elseif($row['actype'][1]==1){
        $client="накопительный %";      
    } else {
        $client="индивидуальный %";
    }
    $trend_purc=unserialize($row['trend_purc']);
		$res2 = mysql_query("SELECT a.*,b.section,b.country FROM preorder_items as a,catalog_items as b WHERE a.gruz_id=b.name and a.order_id = {$row[0]} order by b.country,b.section,b.brand_id,b.model_id,b.description");
		while ($row2 = @mysql_fetch_array($res2)) {
      $percent=$row['percent'];
			$num++;
		  $action=$row2['action'];
		  $amount=$row2['amount'];
      $price=$row2['price'];
      $sum=$price*$amount;
      $estr=$eprice=$esum="";
    if($row['currency']!=''){
      $price=floor($row2['price']*$row['exrate']*$row['ratio']);
      $eprice=$row2['price'];
      $esum=$eprice*$amount;
      $estr=";".$eprice.";".$esum.";".$row['exrate'].";".$row['ratio'];

      $sum=$price*$amount;
      $allesum+=$esum;
    }
      $allsum+=$sum;
      $amt+=$amount;
      $res4 = mysql_query("SELECT a.*,b.name as bname,c.name as cname FROM catalog_items AS a, catalog_brands AS b, catalog_models AS c WHERE a.name = '".$row2['gruz_id']."' AND a.model_id=c.id AND a.brand_id=b.id limit 1");
//echo "SELECT a.*,b.name as bname,c.name as cname FROM catalog_items AS a, catalog_brands AS b, catalog_models AS c WHERE name = '".$row2['name']."' AND a.model_id=c.id AND a.brand_id=b.id limit 1";
      $row4 = mysql_fetch_array($res4);
		  $idgruzzap=$row2['gruz_id'];
      $oem=$row4['oem'];
      $brand=$row4['bname'];//марка
      $model=$row4['cname'];
      $name=$row4['description'];
      $country=$row4['country'];
      $trend=$trends[$row4['section']];
      $manufacturer=$row4['provider'];//$row4['provider'];
      if($trend_purc[$row2['country']."_".$row2['section']]){
        $percent=$trend_purc[$row2['country']."_".$row2['section']];
      }
      $out.=xlsWriteNumber($num,0,$num);
$out.=xlsWriteLabel($num,1,iconv("utf-8","windows-1251",$odate));
$out.=xlsWriteLabel($num,2,iconv("utf-8","windows-1251",$otime));
$out.=xlsWriteLabel($num,3,iconv("utf-8","windows-1251",$idgruzzap));
$out.=xlsWriteNumber($num,4,$oem);
$out.=xlsWriteLabel($num,5,iconv("utf-8","windows-1251",$manufacturer));
$out.=xlsWriteLabel($num,6,iconv("utf-8","windows-1251",$brand));
$out.=xlsWriteLabel($num,7,iconv("utf-8","windows-1251",$model));
$out.=xlsWriteLabel($num,8,iconv("utf-8","windows-1251",$name));
$out.=xlsWriteLabel($num,9,$trend);
$out.=xlsWriteLabel($num,10,iconv("utf-8","windows-1251",$country));
$out.=xlsWriteNumber($num,11,$amount);
$out.=xlsWriteNumber($num,12,$price);
$out.=xlsWriteNumber($num,13,$sum);
$out.=xlsWriteLabel($num,14,iconv("utf-8","windows-1251",$action));
$out.=xlsWriteLabel($num,15,iconv("utf-8","windows-1251",$company));
$out.=xlsWriteLabel($num,16,iconv("utf-8","windows-1251",$uname));
$out.=xlsWriteLabel($num,17,$client);
$out.=xlsWriteNumber($num,18,$percent);
$out.=xlsWriteLabel($num,19,iconv("utf-8","windows-1251",$phone));
$out.=xlsWriteLabel($num,20,iconv("utf-8","windows-1251",$email));
      if($row['currency']!=''){
$out.=xlsWriteNumber($num,21,$eprice);
$out.=xlsWriteNumber($num,22,$esum);
$out.=xlsWriteNumber($num,23,$row['exrate']);
$out.=xlsWriteNumber($num,24,$row['ratio']);
      }
      //$out.=$num.";".$odate.";".$otime.";".$idgruzzap.";".$oem.";".$manufacturer.";".$brand.";".$model.";".$name.";".      $trend.";".$country.";".$amount.";".$price.";".$sum.";".$action.";".$company.";".$uname.";".$client.";".$percent.";".$phone.";".$email.$estr.";\r\n";
		}
	}
	//$allsum="";
	//$out.=";;;;;;;;;;;;;;;;;;;;;\r\n";
	//$out.=";;;;;;;;;;ШТУК;$amt;СУММА;".$allsum.";;;;;;;;;".$allesum.";\r\n";
	//$out=iconv("utf-8","windows-1251",$out);
  $out.=xlsWriteLabel($num+2,11,"ШТУК");
  $out.=xlsWriteNumber($num+2,12,$amt);
  $out.=xlsWriteLabel($num+2,13,"СУММА");
  $out.=xlsWriteNumber($num+2,14,$allsum);
  $out.=xlsWriteNumber($num+2,22,$allesum);
$out.=xlsEOF();
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment;filename=$order_id.xls");
header("Content-Transfer-Encoding: binary ");
echo $out;
} elseif($_GET['partner']=='pulscen'){
  $brand="";
  $model="";
  $oem="";
  $name="";
  $price="";
  $min="2";
  $max="7";
  $amtmin="1";
  $amount="3";
  $url="";
  $rusmodels=Array();
$brnds=Array();$mdls=Array();$rusbrnds=Array();
$resb=mysql_query("SELECT name,altname,rusname FROM catalog_brands WHERE name!=''");
while($rowb=mysql_fetch_row($resb)){
  $brnd=($rowb[1])?$rowb[1]:$rowb[0];
  $brnds[]=$brnd;
  $rusbrnds[$brnd]=iconv("utf-8","windows-1251",$rowb[2]);
}
$resm=mysql_query("SELECT id,name,altname,rusname FROM catalog_models WHERE name!=''");
while($rowm=mysql_fetch_row($resm)){
  $mdl=($rowm[2])?$rowm[2]:$rowm[1];
  $mdls[]=$mdl;
  if($rowm[3]!=""){
    $rusmodels[$mdl]=iconv("utf-8","windows-1251",$rowm[3]);
  }
}

  //echo "here";
  //$out="id товара на сайте PulsCen.ru;Артикул или номер товара;Наименование товара;Точная цена;Цена от…;Цена до…;Валюта;Ссылка на изображение;Рубрика;Краткое описание;Ключевая фраза 1;Ключевая фраза 2;Ключевая фраза 3;Ключевая фраза 4;Ключевая фраза 5;Полное описание;Наличие;Условия оплаты;Сроки доставки;Показать на портале\r\n";
  $out="";
  $res=mysql_query("select a.oem,a.name,a.description,a.price,a.keywords,a.section,a.country,b.id as pid,b.description as des,c.name as brand_name,c.altname as brand_aname,d.name as model_name,d.altname as model_aname from catalog_items as a, catalog_items2 as b,catalog_brands as c, catalog_models as d where a.name=b.linked_item and a.brand_id=c.id and a.model_id=d.id and (a.available !=0 or a.waitingfor!='')");
  $num=0;
  $out=xlsBOF();
  while($row=mysql_fetch_array($res)){
  $num++;
  $brand=($row['brand_aname'])?$row['brand_aname']:$row['brand_name'];
  $model=($row['model_aname'])?$row['model_aname']:$row['model_name'];
  $oem=$row['oem'];
  $name=$row['description'];
  $price=$row['price'];
  if(file_exists("uploaded/".$row['pid'].".jpeg")){
  $picture=$PATH."/uploaded/".$row['pid'].".jpeg";
  } else {
  $picture="";
  }
  $url=$PATH."/catalog/item-".$row['pid']."&b=".urlencode($brand)."&t=".urlencode($model);
  //$out.=$oem.";".$name.";".$brand." - ".$model.";".$price.";".$amount.";\r\n";

  $description=strip_tags($row['des']);
  $description=iconv("utf-8","windows-1251",$description);
    //echo $description;
  $description=trim(substr($description,0,strpos($description,"Альтернативный номер")));
  //echo "<br><b> - $description </b>";
  if($row['section']==2){
    $section="http://www.pulscen.ru/predl/transport/autoparts/trukspares/kuzov";
  } elseif($row['section']==1){
    if(strstr($name,'зеркал')!==false || strstr($description,'зеркал')!==false){
      $section="http://www.pulscen.ru/predl/transport/autoparts/trukspares/zerkala"; 
    } else {
      $section="http://www.pulscen.ru/predl/transport/autoparts/trukspares/lampy"; 
    }
  } else {
    $section="";
  }
  
  ///begin

    if(array_key_exists($model,$rusmodels)){
      $rmdls=explode(" ",$rusmodels[$md]);
      $rmdl=$rusmodels[$md];
    } else {
      $rmdl=$md;
      $rmdls=$mds;
    }
		$brs=explode(" ",$brand);
		$mds=explode(" ",$model);
		$rbr=explode(" ",$rusbrnds[$brand]);
    //$spec=strip_tags(iconv("utf-8","windows-1251",$description));
    $keywords=str_replace("{brand}",$brand,$row['keywords']);
		$description=str_replace("{brand}",$brand,$description);

		$description=str_replace("{brand1}",$brs[0],$description);
		$keywords=str_replace("{brand1}",$brs[0],$keywords);
		$description=str_replace("{model}",$model,$description);	
    $keywords=str_replace("{model}",$model,$keywords);	
		$description=str_replace("{model1}",$mds[0],$description);
		$keywords=str_replace("{model1}",$mds[0],$keywords);
		$description=str_replace("{model2}",$mds[0]." ".$mds[1],$description);
		$keywords=str_replace("{model2}",$mds[0]." ".$mds[1],$keywords);
		$description=str_replace("{rusbrand}",mb_strtolower($rusbrnds[$brand], "Windows-1251"),$description);
    $keywords=str_replace("{rusbrand}",$rusbrnds[$brand],$keywords);
    
 		$description=str_replace("{rusbrand1}",$rbr[0],$description);
    $keywords=str_replace("{rusbrand1}",$rbr[0],$keywords);   
    $description=str_replace("{rusmodel}",mb_strtolower($rmdl, "Windows-1251"),$description);
    $keywords=str_replace("{rusmodel}",$rmdl,$keywords);
    $description=str_replace("{rusmodel1}",mb_strtolower($rmdls[0], "Windows-1251"),$description);
    $keywords=str_replace("{rusmodel1}",$rmdls[0],$keywords);
		// {fh;mx;fm};
		if(preg_match_all("!\{[a-z0-9-_]+,[^\{]+\}!is",$description,$match)){
      $brk=Array("{","}");
      $mtch=str_replace($brk,"",$match[0][0]);
      $mtch=explode(",",$mtch);
		  foreach($mtch as $d1=>$d2){
        if(stristr($model,$d2)){
          $description=str_replace($match[0],$d2,$description);
          break;
        }
      }
		}
		if(preg_match_all("!\{[A-Za-z0-9-_]+,[^\{]+\}!is",$keywords,$match)){
      $brk=Array("{","}");
      $mtch=str_replace($brk,"",$match[0][0]);
      $mtch=explode(",",$mtch);
		  foreach($mtch as $d1=>$d2){
        if(stristr($model,$d2)){
          $keywords=str_replace($match[0],$d2,$keywords);
          break;
        }
      }
		}
		//echo $keywords;
  $keywords=explode(",",$keywords);
  for($i=0;$i<5;$i++){
      $key[$i]=(strlen($keywords[$i])>2)?trim($keywords[$i]):"";
  }

///end
  
  $out.=xlsWriteLabel($num,0,'');
  $out.=xlsWriteLabel($num,1,iconv("utf-8","windows-1251",$row['name']));
  $out.=xlsWriteLabel($num,2,iconv("utf-8","windows-1251",$name));
  $out.=xlsWriteNumber($num,3,iconv("utf-8","windows-1251",$price));
  $out.=xlsWriteLabel($num,4,'');
  $out.=xlsWriteLabel($num,5,'');
  $out.=xlsWriteLabel($num,6,'руб.');
  $out.=xlsWriteLabel($num,7,iconv("utf-8","windows-1251",$picture));
  $out.=xlsWriteLabel($num,8,iconv("utf-8","windows-1251",$section));
  $out.=xlsWriteLabel($num,9,iconv("utf-8","windows-1251","$brand $model $name ({$row['country']})"));
  $out.=xlsWriteLabel($num,10,iconv("utf-8","windows-1251",$key[0]));
  $out.=xlsWriteLabel($num,11,iconv("utf-8","windows-1251",$key[1]));
  $out.=xlsWriteLabel($num,12,iconv("utf-8","windows-1251",$key[2]));
  $out.=xlsWriteLabel($num,13,iconv("utf-8","windows-1251",$key[3]));
  $out.=xlsWriteLabel($num,14,iconv("utf-8","windows-1251",$key[4]));
  $out.=xlsWriteLabel($num,15,$description);
  $out.=xlsWriteLabel($num,16,'наличие');
  $out.=xlsWriteLabel($num,17,'');
  $out.=xlsWriteLabel($num,18,'2 дня');
  $out.=xlsWriteLabel($num,19,'да');
  //$out.=";{$row['name']};$name;$price; ; ;руб.;$picture;$section;$brand $model $name ({$row['country']});{$key[0]};{$key[1]};{$key[2]};{$key[3]};{$key[4]};$description;наличие; ;1 день;да\r\n";

  }
  $out.=xlsEOF();

  header("Content-Type: application/force-download");
  header("Content-Type: application/octet-stream");
  header("Content-Type: application/download");
  header("Content-Disposition: attachment;filename=price_".$_GET['partner'].".xls");
  header("Content-Transfer-Encoding: binary ");
  echo $out;

}
?>