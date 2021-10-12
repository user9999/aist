<?php  if (!defined("ADMIN_SIMPLE_CMS")) die("Access denied"); 
$sections=array("", "Оптика", "Кузовные запчасти", "Аксессуары"); 
foreach($sections as $key=>$value){
  //echo "pre ".$key;
  if(glob("cache/section-".$key)){
    //echo "here".$key;
    if(glob("cache/section-".$key."/page*.php")){
      foreach(glob("cache/section-".$key."/page*.php") as $cache){
        unlink($cache);
      }
    }
    $res2 = mysql_query("SELECT b.id,b.name AS position_name,b.oem,c.name AS modelname,c.altname AS altmodelname, b.price,b.quantity,b.waitingfor,b.description,b.special,b.available,d.name,b.country AS brandname FROM catalog_items AS b,catalog_models AS c,catalog_brands AS d WHERE b.model_id = c.id AND b.brand_id = d.id AND b.waitingfor!='архив' AND b.section=".$key." ORDER BY d.name,c.name,b.description");
    $out="";
    $s=0;$page="";
    $showimg=1;
    $numrows=mysql_num_rows($res2);
    while($row2=mysql_fetch_row($res2)){
      $s++;
      if ($row2[4]) $row2[3] = $row2[4];
        $sid = 0;
        $res3 = mysql_query("SELECT * FROM catalog_items2 WHERE linked_item = '{$row2[1]}'");
        if ($r3 = mysql_fetch_row($res3)) {
          $row2[1] = $r3[1];
          $sid = $r3[0];
        }
        if($row2[10]>0){
          $av=0;
        } elseif($row2[7]!="" && $row2[7]!=0){
          $av=2;
        } else {
          $av=1;
        }	
        $out.="<tr id=\"tr_{$row2[0]}\">"; 
      $linkage="item-";
      if(!$showimg){
        $out.="<td><a href='{$GLOBALS['PATH']}/catalog/$linkage".$sid."'><b>{$row2[2]}</b></a></td>
<td>{$row2[11]}<br>".$row2[3];
      } else {
        $out.="<td>";
        $fl = "";
        if (file_exists("uploaded/small_$sid.jpeg")) $fl = "{$GLOBALS['PATH']}/uploaded/small_$sid.jpeg";
        if (file_exists("uploaded/small_$sid.png")) $fl = "{$GLOBALS['PATH']}/uploaded/small_$sid.png";
        if (file_exists("uploaded/small_$sid.gif")) $fl = "{$GLOBALS['PATH']}/uploaded/small_$sid.gif";
        if ($fl) {
          $out.="<a class=\"underlined\" href='{$GLOBALS['PATH']}/catalog/$linkage".$sid."&amp;b=".urlencode($row2[11])."&amp;t=".urlencode($row2[3])."'><img src='$fl' alt=''></a>";
        } else {
          $out.="<a class=\"underlined\" href='{$GLOBALS['PATH']}/catalog/$linkage".$sid."&amp;b=".urlencode($row2[11])."&amp;t=".urlencode($row2[3])."'><img src='{$GLOBALS['PATH']}/img/small_nofoto.jpg' alt=''></a>";			
        }
        $out.="</td><td><a class=\"underlined\" href='{$GLOBALS['PATH']}/catalog/$linkage".$sid."&amp;b=".urlencode($row2[11])."&amp;t=".urlencode($row2[3])."'><b>{$row2[2]}</b></a></td>
		<td>{$row2[11]}<br>{$row2[3]}</td>";
      }
      $out.="<td><a class=\"underlined\" href='{$GLOBALS['PATH']}/catalog/$linkage".$sid."&amp;b=".urlencode($row2[11])."&amp;t=".urlencode($row2[3])."'>{$row2[8]}</a>";
      if($row2[9]!=""){	
        $out.="<br><a href=\"".$PATH."/static/special\" style=\"color:red;font-weight:bold\">Акция!!!</a>";
      }
      $out.="</td><td class=\"rightal\">";
      if ($row2[5]!=0){
        $out.=$row2[5]." руб."; 
      } 
      $out.="</td>
<td><input style=\"width: 25px;\" id=\"i{$row2[0]}\" value=\"$searchv\"></td><td>";
      if ($row2[5]!= 0){
        $out.=" &nbsp; <a href='javascript:addToCart({$row2[0]}, {$row2[5]});'><img title='купить  {$row2[8]}' alt='купить  {$row2[8]}' src='" . $GLOBALS['PATH'] . "/templates/blank/img/cartadd.png'></a>";
      } 
      $out.="</td></tr>";
      if ($s == 0) $out.="<tr><td colspan=8>Не найдено ни одной позиции</td></tr>";
      $np=$s%40;
      if(($np==0 && $out) || ($numrows==$s && $out)){
        $fp=fopen("cache/section-".$key."/page".$page.".php","w+");
        fwrite($fp,$out);
        fclose($fp);
        $page++;
        $out="";
      }
          $c[$key]=$page;
    }
    
/////////////////////archive

    if(glob("cache/section-".$key."/archpage*.php")){
      foreach(glob("cache/section-".$key."/archpage*.php") as $cache){
        unlink($cache);
      }
    }
    $res2 = mysql_query("SELECT b.id,b.name AS position_name,b.oem,c.name AS modelname,c.altname AS altmodelname, b.price,b.quantity,b.waitingfor,b.description,b.special,b.available,d.name,b.country AS brandname FROM catalog_items AS b,catalog_models AS c,catalog_brands AS d WHERE b.model_id = c.id AND b.brand_id = d.id AND b.waitingfor='архив' AND b.section=".$key." ORDER BY d.name,c.name,b.description");
    $out="";
    $s=0;$page="";
    $showimg=1;
    $numrows=mysql_num_rows($res2);
    while($row2=mysql_fetch_row($res2)){
      $s++;
      if ($row2[4]) $row2[3] = $row2[4];
        $sid = 0;
        $res3 = mysql_query("SELECT * FROM catalog_items2 WHERE linked_item = '{$row2[1]}'");
        if ($r3 = mysql_fetch_row($res3)) {
          $row2[1] = $r3[1];
          $sid = $r3[0];
        }
        if($row2[10]>0){
          $av=0;
        } elseif($row2[7]!="" && $row2[7]!=0){
          $av=2;
        } else {
          $av=1;
        }	
        $out.="<tr id=\"tr_{$row2[0]}\">"; 
      $linkage = "item-";
      if(!$showimg){
        $out.="<td><a href='{$GLOBALS['PATH']}/catalog/$linkage".$sid."'><b>{$row2[2]}</b></a></td>
<td>{$row2[11]}<br>".$row2[3];
      } else {
        $out.="<td>";
        $fl = "";
        if (file_exists("uploaded/small_$sid.jpeg")) $fl = "{$GLOBALS['PATH']}/uploaded/small_$sid.jpeg";
        if (file_exists("uploaded/small_$sid.png")) $fl = "{$GLOBALS['PATH']}/uploaded/small_$sid.png";
        if (file_exists("uploaded/small_$sid.gif")) $fl = "{$GLOBALS['PATH']}/uploaded/small_$sid.gif";
        if ($fl) {
          $out.="<img src='$fl' alt=''>";
        }
        $out.="</td><td><a class=\"underlined\" href='{$GLOBALS['PATH']}/catalog/$linkage".$sid."&amp;b=".urlencode($row2[11])."&amp;t=".urlencode($row2[3])."'><b>{$row2[2]}</b></a></td>
		<td>{$row2[11]}<br>{$row2[3]}</td>";
      }
      $out.="<td><a class=\"underlined\" href='{$GLOBALS['PATH']}/catalog/$linkage".$sid."&amp;b=".urlencode($row2[11])."&amp;t=".urlencode($row2[3])."'>{$row2[8]}</a>";
      if($row2[9]!=""){	
        $out.="<br><a href=\"".$PATH."/static/special\" style=\"color:red;font-weight:bold\">Акция!!!</a>";
      }
      $out.="</td><td class=\"rightal\">";
      if ($row2[5]!=0){
        $out.=$row2[5]." руб."; 
      } 
      $out.="</tr>";
      /*
      if ($row2[5]!= 0){
        $out.=" &nbsp; <a href='javascript:addToCart({$row2[0]}, {$row2[5]});'><img title='купить  {$row2[8]}' alt='купить  {$row2[8]}' src='" . $GLOBALS['PATH'] . "/templates/blank/img/cartadd.png'></a>";
      } 

      $out.="</td></tr>";
      */
      if ($s == 0) $out.="<tr><td colspan=8>Не найдено ни одной позиции</td></tr>";
      $np=$s%40;
      if(($np==0 && $out) || ($numrows==$s && $out)){
        $fp=fopen("cache/section-".$key."/archpage".$page.".php","w+");
        fwrite($fp,$out);
        fclose($fp);
        $page++;
        $out="";
      }
          $ac[$key]=$page;
    }
  }
  if(glob("cache/section-".$key."/page*.php")){
      $links="";
      for($i=0;$i<$c[$key];$i++){
        $param=($i==0)?"":"&amp;p=".$i;
        $links.="<a href=\"{$GLOBALS['PATH']}/catalog/section-".$key.$param."\">".($i+1)."</a> ";
      }
      $add="</tbody></table><br><table style=\"width:100%\"><tbody><tr id=\"pagination\"><td>Страницы: $links</td></tr>";
      foreach(glob("cache/section-".$key."/page*.php") as $cache){
      
      	$num=str_replace("cache/section-".$key."/page","",$cache);
        $num=str_replace(".php","",$num);
        if(strstr($add,">".($num+1)."<")){
          $clink=str_replace(">".($num+1)."<","><b>".($num+1)."</b><",$add);
        }
        $fp=fopen($cache,"a+");
        fwrite($fp,$clink);
        fclose($fp);
      }
    }
    if(glob("cache/section-".$key."/archpage*.php")){
      $links="";
      for($i=0;$i<$ac[$key];$i++){
        $param=($i==0)?"":"&amp;p=".$i;
        $links.="<a href=\"{$GLOBALS['PATH']}/catalog/section-".$key."&stat=archive".$param."\">".($i+1)."</a> ";
      }
      $add="</tbody></table><br><table style=\"width:100%\"><tbody><tr id=\"pagination\"><td>Страницы: $links</td></tr>";
      foreach(glob("cache/section-".$key."/archpage*.php") as $cache){
      
        $num=str_replace("cache/section-".$key."/archpage","",$cache);
        $num=str_replace(".php","",$num);
        if(strstr($add,">".($num+1)."<")){
          $clink=str_replace(">".($num+1)."<","><b>".($num+1)."</b><",$add);
        }
        $fp=fopen($cache,"a+");
        fwrite($fp,$clink);
        fclose($fp);
      }
    }
}
?>
