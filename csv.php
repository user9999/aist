<?php
session_start();
//header("Content-Type: text/plain; charset=windows-1251");
//header("Content-Transfer-Encoding: windows-1251");
if (!isset($_SESSION['admin_name'])) die('--');
$trends=array("","Оптика","Кузовные запчасти","Аксессуары");
if (isset($_GET['order_id'])) {
	$order_id = (int) $_GET['order_id'];
  require_once("inc/configuration.php");
  require_once("inc/functions.php");
  $company="";//
  $odate="";//
  $otime="";//
  $idgruzzap="";//
  $oem="";//
  $brand="";//марка
  $model="";
  $name="";//
  $country="";//
  $manufacturer="";
  $amount="";//
  $price="";//
  $sum="";//
  $action="";//
  $uname="";//
  $phone="";//
  $email="";//
  $client="обычный";
  $percent="0";
  $allsum=0;$amt=0;
  $num=0;
  $trend="";
  $out="№;Дата;Время;ID Груз-Зап;ОЕМ;ID Произв-ля;Марка;Модель;Наименование;Направление;Производитель;Кол-во;Цена;Сумма;Акция;Фирма;ФИО;тип клиента;Скидка(%);Тел;E-mail;";
	$res = mysql_query("SELECT * FROM orders WHERE id = $order_id");
	if ($row = mysql_fetch_array($res)) {
    if($row['currency']!=''){
      $cur=($row['currency']=='euro')?"евро":"долларах";
      $out.="Цена в $cur;Сумма в $cur;Курс;Коэффициент;\r\n";
    } else {
      $out.="\r\n";
    }
	  $odate=date("d.m.Y", $row['date']);
	  $otime=date("H:i", $row['date']);
    $uname=$row['name'];
    $phone=$row['phone'];
    $email=$row['email'];
		if($row['utype']!=0){
      $res3 = mysql_query("SELECT * FROM users WHERE id = '".$row['user_id']."' limit 1");//, SUM(price) as sumprice
      $row3 = mysql_fetch_array($res3);
      if($row3['actype'][0]==1){
        $client="прайс-лист";
      } elseif($row3['actype'][1]==1){
        $client="накопительный %";      
      } else {
        $client="индивидуальный %";
      }
      $trend_purc=unserialize($row3['trend_purc']);
      //$percent=$row3['percent'];
      
      $company=$row3['company'];
      $uname=$row3['name'];
      $phone=str_replace("\r\n"," ",$row3['udata']);
      $email=$row3['email'];
		}
		//$res2 = mysql_query("SELECT * FROM orders_items WHERE orders_id = {$row[0]} order by item_id");//, SUM(price) as sumprice
		$res2 = mysql_query("SELECT a.*,b.section,b.country FROM orders_items as a,catalog_items as b WHERE a.name=b.name and a.orders_id = {$row[0]} order by  b.country,b.section,b.brand_id,b.model_id,b.description");
		while ($row2 = @mysql_fetch_array($res2)) {
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
//echo "SELECT a.*,b.name as bname,c.name as cname FROM catalog_items AS a, catalog_brands AS b, catalog_models AS c WHERE name = '".$row2['name']."' AND a.model_id=c.id AND a.brand_id=b.id limit 1";
      $row4 = mysql_fetch_array($res4);
		  $idgruzzap=$row2['name'];
      $oem=$row4['oem'];
      $brand=$row4['bname'];//марка
      $model=$row4['cname'];
      $name=$row4['description'];
      $country=$row4['country'];
      $trend=$trends[$row4['section']];
      $manufacturer=$row4['provider'];//$row4['manufacturer'];
      $out.=$num.";".$odate.";".$otime.";".$idgruzzap.";".$oem.";".$manufacturer.";".$brand.";".$model.";".$name.";".$trend.";".$country.";".$amount.";".$price.";".$sum.";".$action.";".$company.";".$uname.";".$client.";".$percent.";".$phone.";".$email.$estr.";\r\n";
		}
	}
	//$allsum="";
	$out.=";;;;;;;;;;;;;;;;;;;;\r\n";
	$out.=";;;;;;;;;;ШТУК;$amt;СУММА;".$allsum.";;;;;;;;;".$allesum.";\r\n";
	$out=iconv("utf-8","windows-1251",$out);
	//die();
	//$fp=fopen("uploaded/files/".$order_id.".csv","w+");
	//fwrite($fp,$out);
	//fclose($fp);
	//header("Location: $PATH/uploaded/files/".$order_id.".csv");
	//header("Content-Type: application/CSV");
	//header("Content-Disposition: attachment;filename=".$order_id.".csv");
if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")){   
    header("Cache-Control: ");// leave blank to avoid IE errors 
    header("Pragma: ");// leave blank to avoid IE errors 
    header("Cache-control: private");
    header("Connection: Keep-Alive"); 
    //header("Content-type: application/csv; charset=windows-1251");
 		header("Content-Type: application/octet-stream");
 		header('Content-Length: ' . filesize($out));
   
    header("Content-Disposition: attachment; filename=".$order_id.".csv");
    header("Content-Transfer-Encoding: binary\n");
    //header("Content-Transfer-Encoding: binary");
} else {
	header("Content-Type: application/CSV");
	header("Content-Disposition: attachment;filename=".$order_id.".csv");
	}

} elseif(isset($_GET['preorder_id'])){
	$order_id = (int) $_GET['preorder_id'];
  require_once("inc/configuration.php");
  require_once("inc/functions.php");
  $company="";//
  $odate="";//
  $otime="";//
  $idgruzzap="";//
  $oem="";//
  $brand="";//марка
  $model="";
  $name="";//
  $country="";//
  $manufacturer="";
  $amount="";//
  $price="";//
  $sum="";//
  $action="";//
  $uname="";//
  $phone="";//
  $email="";//
  $client="обычный";
  $percent="0";
  $allsum=0;$amt=0;
  $trend="";
  $out="№;Дата;Время;ID Груз-Зап;ОЕМ;ID Произв-ля;Марка;Модель;Наименование;Направление;Производитель;Кол-во;Цена;Сумма;Акция;Фирма;ФИО;тип клиента;Скидка(%);Тел;E-mail;";
	$res = mysql_query("SELECT a.*,b.name,b.email,b.company,b.actype,b.percent,b.udata,b.trend_purc FROM preorder_admin as a,users as b WHERE a.user_id=b.id and a.id = $order_id");
	$num=0;
	if ($row = mysql_fetch_array($res)) {
	  if($row['currency']!=''){
      $cur=($row['currency']=='euro')?"евро":"долларах";
      $out.="Цена в $cur;Сумма в $cur;Курс;Коэффициент;\r\n";
    } else {
      $out.="\r\n";
    }
		//var_dump($row );

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
		//$res2 = mysql_query("SELECT * FROM preorder_items WHERE order_id = {$row[0]} order by gruz_id");//, SUM(price) as sumprice
		$res2 = mysql_query("SELECT a.*,b.section,b.country FROM preorder_items as a,catalog_items as b WHERE a.gruz_id=b.name and a.order_id = {$row[0]} order by b.country,b.section,b.brand_id,b.model_id,b.description");
		//echo "SELECT a.*,b.section FROM preorder_items as a,catalog_items as b WHERE a.gruz_id=b.name and a.order_id = {$row[0]} order by b.country,b.section,b.brand_id,b.model_id,b.description";
		//die();
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
      $out.=$num.";".$odate.";".$otime.";".$idgruzzap.";".$oem.";".$manufacturer.";".$brand.";".$model.";".$name.";".      $trend.";".$country.";".$amount.";".$price.";".$sum.";".$action.";".$company.";".$uname.";".$client.";".$percent.";".$phone.";".$email.$estr.";\r\n";
		}
	}
	//$allsum="";
	$out.=";;;;;;;;;;;;;;;;;;;;;\r\n";
	$out.=";;;;;;;;;;ШТУК;$amt;СУММА;".$allsum.";;;;;;;;;".$allesum.";\r\n";
	$out=iconv("utf-8","windows-1251",$out);
	//die();
	//$fp=fopen("uploaded/files/".$order_id.".csv","w+");
	//fwrite($fp,$out);
	//fclose($fp);
	//header("Location: $PATH/uploaded/files/".$order_id.".csv");
	//header("Content-Type: application/CSV");
	//header("Content-Disposition: attachment;filename=".$order_id.".csv");
if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")){   
    header("Cache-Control: ");// leave blank to avoid IE errors 
    header("Pragma: ");// leave blank to avoid IE errors 
    header("Cache-control: private");
    header("Connection: Keep-Alive"); 
    //header("Content-type: application/csv; charset=windows-1251");
 		header("Content-Type: application/octet-stream");
 		header('Content-Length: ' . filesize($out));
   
    header("Content-Disposition: attachment; filename=".$order_id.".csv");
    header("Content-Transfer-Encoding: binary\n");
    //header("Content-Transfer-Encoding: binary");

} else {
	header("Content-Type: application/CSV");
	header("Content-Disposition: attachment;filename=".$order_id.".csv");
	}
} elseif($_GET['partner']=='autoru'){
  require_once("inc/configuration.php");
  require_once("inc/functions.php");
  $brand="";
  $model="";
  $oem="";
  $name="";
  $price="";
  $min="2";
  $max="7";
  $amtmin="1";
  $amount="";
  $url="";
  $out="производитель;номер;название;цена (в руб.) РОЗНИЦА;срок поставки  min;срок поставки max;минимальное кол-во для поставки;остаток на складе;URL;\r\n";
  $res=mysql_query("select a.oem,a.description,a.price,a.country,b.id as pid,c.name as brand_name,c.altname as brand_aname,d.name as model_name,d.altname as model_aname from catalog_items as a, catalog_items2 as b,catalog_brands as c, catalog_models as d where a.name=b.linked_item and a.brand_id=c.id and a.model_id=d.id and (a.available !=0 or a.waitingfor!='')");
  while($row=mysql_fetch_array($res)){
  $brand=($row['brand_aname'])?$row['brand_aname']:$row['brand_name'];
  $model=($row['model_aname'])?$row['model_aname']:$row['model_name'];
  $oem=$row['oem'];
  $name=$row['description'];
  $price=$row['price'];
  $url=$PATH."/catalog/item-".$row['pid']."&b=".urlencode($brand)."&t=".urlencode($model);
  $out.=$brand.";".$oem.";".$name.";".$price.",00;".$min.";".$max.";".$amtmin.";".$amount.";".$url.";\r\n";
  }
	//$out=iconv("utf-8","windows-1251",$out);
	$out=mb_convert_encoding($out, "windows-1251", "utf-8");
  if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")){   
    header("Cache-Control: ");// leave blank to avoid IE errors 
    header("Pragma: ");// leave blank to avoid IE errors 
    header("Cache-control: private");
    header("Connection: Keep-Alive"); 
    //header("Content-type: application/csv; charset=windows-1251");
 		header("Content-Type: application/octet-stream");
 		header('Content-Length: ' . filesize($out));
   
    header("Content-Disposition: attachment; filename=price_".$_GET['partner'].".csv");
    header("Content-Transfer-Encoding: binary\n");
    //header("Content-Transfer-Encoding: binary");
  } else {
	header("Content-Type: application/CSV");
	header("Content-Disposition: attachment;filename=price_".$_GET['partner'].".csv");
	}
} elseif($_GET['partner']=='partfast'){
  require_once("inc/configuration.php");
  require_once("inc/functions.php");
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
  //$out="производитель;номер;название;цена (в руб.) РОЗНИЦА;срок поставки  min;срок поставки max;минимальное кол-во для поставки;остаток на складе;URL;\r\n";
  $out="";
  $res=mysql_query("select a.oem,a.description,a.price,a.country,b.id as pid,c.name as brand_name,c.altname as brand_aname,d.name as model_name,d.altname as model_aname from catalog_items as a, catalog_items2 as b,catalog_brands as c, catalog_models as d where a.name=b.linked_item and a.brand_id=c.id and a.model_id=d.id and (a.available !=0 or a.waitingfor!='')");
  while($row=mysql_fetch_array($res)){
  $brand=($row['brand_aname'])?$row['brand_aname']:$row['brand_name'];
  $model=($row['model_aname'])?$row['model_aname']:$row['model_name'];
  $oem=$row['oem'];
  $name=$row['description'];
  $price=$row['price'];
  $url=$PATH."/catalog/item-".$row['pid']."&b=".urlencode($brand)."&t=".urlencode($model);
  $out.=$oem.";".$name.";".$brand." - ".$model.";".$price.";".$amount.";\r\n";
  }
	//$out=iconv("utf-8","windows-1251",$out);
	$out=mb_convert_encoding($out, "windows-1251", "utf-8");
  if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")){   
    header("Cache-Control: ");// leave blank to avoid IE errors 
    header("Pragma: ");// leave blank to avoid IE errors 
    header("Cache-control: private");
    header("Connection: Keep-Alive"); 
    //header("Content-type: application/csv; charset=windows-1251");
 		header("Content-Type: application/octet-stream");
 		header('Content-Length: ' . filesize($out));
   
    header("Content-Disposition: attachment; filename=price_".$_GET['partner'].".csv");
    header("Content-Transfer-Encoding: binary\n");
    //header("Content-Transfer-Encoding: binary");

} else {
	header("Content-Type: application/CSV");
	header("Content-Disposition: attachment;filename=price_".$_GET['partner'].".csv");
	}
} elseif($_GET['partner']=='pulscen'){
  require_once("inc/configuration.php");
  require_once("inc/functions.php");
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
  //$out="id товара на сайте PulsCen.ru;Артикул или номер товара;Наименование товара;Точная цена;Цена от…;Цена до…;Валюта;Ссылка на изображение;Рубрика;Краткое описание;Ключевая фраза 1;Ключевая фраза 2;Ключевая фраза 3;Ключевая фраза 4;Ключевая фраза 5;Полное описание;Наличие;Условия оплаты;Сроки доставки;Показать на портале\r\n";
  $out="";
  $res=mysql_query("select a.oem,a.name,a.description,a.price,a.keywords,a.section,a.country,b.id as pid,b.description as des,c.name as brand_name,c.altname as brand_aname,d.name as model_name,d.altname as model_aname from catalog_items as a, catalog_items2 as b,catalog_brands as c, catalog_models as d where a.name=b.linked_item and a.brand_id=c.id and a.model_id=d.id and (a.available !=0 or a.waitingfor!='')");
  while($row=mysql_fetch_array($res)){
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
  $keywords=explode(",",$row['keywords']);
  for($i=0;$i<5;$i++){
      $key[$i]=(strlen($keywords[$i])>2)?trim($keywords[$i]):"";
  }
  $description=strip_tags($row['des']);
  $description=trim(substr($description,0,strpos($description,"Альтернативные")));
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
  $out.=";{$row['name']};$name;$price; ; ;руб.;$picture;$section;$brand $model $name ({$row['country']});{$key[0]};{$key[1]};{$key[2]};{$key[3]};{$key[4]};$description;наличие; ;1 день;да\r\n";

  }
	//$out=iconv("utf-8","windows-1251",$out);
	//$out=mb_convert_encoding($out, "windows-1251", "utf-8");
  if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")){   
    header("Cache-Control: ");// leave blank to avoid IE errors 
    header("Pragma: ");// leave blank to avoid IE errors 
    header("Cache-control: private");
    header("Connection: Keep-Alive"); 
    //header("Content-type: application/csv; charset=windows-1251");
 		header("Content-Type: application/octet-stream");
 		header('Content-Length: ' . filesize($out));
   
    header("Content-Disposition: attachment; filename=price_".$_GET['partner'].".csv");
    header("Content-Transfer-Encoding: binary\n");
    //header("Content-Transfer-Encoding: binary");

} else {
	header("Content-Type: application/CSV");
	header("Content-Disposition: attachment;filename=price_".$_GET['partner'].".csv");
	}
}
echo $out;
?>
