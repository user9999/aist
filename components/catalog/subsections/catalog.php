<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
//$_GET['id'] - $segments
//var_dump($last_section);
//echo $last_section;
//die();

if (!isset($csection)) { 
    header("HTTP/1.0 404 Not Found");
    header("Location: " . $GLOBALS['PATH'] . "/404");
}
$level=count($segments);


if(strpos($segments[$level-1], "item-")!==false) {
    header("HTTP/1.0 404 Not Found");
    include "components/404/template.404.php";
    $PAGE_BODY = ob_get_contents();
    ob_clean();
    if (file_exists("templates/$TEMPLATE/$component.template.php")) {
        include "templates/$TEMPLATE/$component.template.php";
    } 
    die();
}


$catalog=mysql_real_escape_string($catalog);
$last_section=mysql_real_escape_string($last_section);
if(strpos($last_section, "item-")===false) {
    //echo "<!--mydump ".$catalog."-->";
    $s="";
    //echo $_GET['s'];
    switch ($_GET['s']){
    case 'up':
        $order=" order by CAST(a.price as UNSIGNED)";
        break;
    case 'down':
        $order=" order by CAST(a.price as UNSIGNED) DESC";
        break;
    case 'title':
        $order=" order by a.description";
        break;
    default:
        $order="";
        break;
    }
    $wh="";
    if($_GET['c']) {
        //$getc=urldencode($_GET['c']);
        foreach($_GET['c'] as $ns=>$vs){
            if($vs!='all') {
                  $wh.="and a.column$ns='".urldecode($vs)."' ";
            }
        }
    }
    //echo $wh;
    $tov=mysql_query("SELECT a.id, a.oem, a.model,a.description as itemtitle, a.available,a.price,a.country,a.column1,a.column2,a.column3,a.column4,b.id as bid,b.alt,b.description as description from catalog_items as a, catalog_items2 as b where b.linked_item=a.name $wh and (a.section_id='{$catalog}' or a.section='{$catalog}')".$order);
    //$tov=mysql_query("SELECT a.id, a.name as subsection, a.altname as altsubsection, a.showimg, b.name as section, b.altname as altsection FROM catalog_subsections AS a, catalog_sections AS b WHERE a.section_id = '{$catalog}'");
    //echo "SELECT a.id, a.model,a.description as itemtitle, a.available,a.price,a.country,a.column1,a.column2,a.column3,a.column4,b.id as bid,b.alt,b.description as description from catalog_items as a, catalog_items2 as b where b.linked_item=a.name and (a.section_id='{$catalog}' or a.subsection_id='{$catalog}' or a.section='{$catalog}')".$order;
    //echo $catalog;
    $parts=explode("/", $catalog);
    //var_dump($parts);
    $where="";
    foreach($parts as $num=>$val){
        $where.="altname='{$val}' or ";
    }
    $where="(".substr($where, 0, -4).")";
    //echo "select name,altname from catalog_sections where $where and showmenu=1";
    $rb=mysql_query("select name,altname,sortby from catalog_sections where $where and showmenu=1  order by level");
    $l="";$link="";
    while($rwb=mysql_fetch_assoc($rb)){
        if($last_section==$rwb['altname']) { $sortarr=unserialize($rwb['sortby']);
        }
        //$sortarr=$rwb['sortby'];
        $link.="<a href='/catalog/".$l.$rwb['altname']."'>{$rwb['name']}</a> / ";
        $l.=$rwb['altname']."/";
    }
    $link=substr($link, 0, -2);
    render_to_template("components/catalog/template.breadcrumbs.php", array('link'=>$link));
    if(mysql_num_rows($tov)) {///товары
        //echo "<!--mydump ";
        //var_dump($sortarr[3]);
        //echo "-->";
        //echo "<!--mydump "."select column1,column2,column3,column4 from catalog_items where section_id='".$catalog."'\n";
        $ressortby=mysql_query("select column1,column2,column3,column4 from catalog_items where section_id='".$catalog."'");
        if($sortarr[1]!==null) { $row['sort'][$sortarr[1]]=array();
        }
        if($sortarr[2]!==null) { $row['sort'][$sortarr[2]]=array();
        }
        if($sortarr[3]!==null) { $row['sort'][$sortarr[3]]=array();
        }
        if($sortarr[4]!==null) { $row['sort'][$sortarr[4]]=array();
        }
        
        while($rowsortby=mysql_fetch_array($ressortby)){
            if($sortarr[1]!==null && !in_array($rowsortby[0], $row['sort'][$sortarr[1]]) && $rowsortby[0]!="") {
                $row['sort'][$sortarr[1]][]=$rowsortby[0];
            }
            if($sortarr[2]!==null && !in_array($rowsortby[1], $row['sort'][$sortarr[2]]) && $rowsortby[1]!="") {
                $row['sort'][$sortarr[2]][]=$rowsortby[1];
            }
            if($sortarr[3]!==null && !in_array($rowsortby[2], $row['sort'][$sortarr[3]]) && $rowsortby[2]!="") {
                $row['sort'][$sortarr[3]][]=$rowsortby[2];
            }
            if($sortarr[4]!==null && !in_array($rowsortby[3], $row['sort'][$sortarr[4]]) && $rowsortby[3]!="") {
                $row['sort'][$sortarr[4]][]=$rowsortby[3];
            }
        }
        if($sortarr[1]!==null) { asort($row['sort'][$sortarr[1]]);
        }
        if($sortarr[2]!==null) { asort($row['sort'][$sortarr[2]]);
        }
        if($sortarr[3]!==null) { asort($row['sort'][$sortarr[3]]);
        }
        if($sortarr[4]!==null) { asort($row['sort'][$sortarr[4]]);
        }
        //$row['sortby']=$sortarr;
        //var_dump($row['sort']);
        //echo "-->";
        //echo "SELECT a.id, a.name as subsection, a.altname as altsubsection, a.showimg, b.name as section, b.altname as altsection,c.name as brand,a.sortby FROM catalog_subsections AS a, catalog_sections AS b, catalog_brands AS c WHERE a.section_id = '{$catalog}'";
        
        //render_to_template("components/catalog/template.menu.php",array());
        render_to_template("components/catalog/template.tableHeader.php", array());
        render_to_template("components/catalog/template.sortby.php", $row);
        while($res=mysql_fetch_assoc($tov)){
            
            render_to_template("components/catalog/template.tableIn.php", $res);
        }
    
    } else {

        $res=mysql_query("SELECT * from catalog_sections where level=".($level)." and altname='".$last_section."' and showmenu=1 limit 1");

        $row=mysql_fetch_array($res);
        //echo "SELECT * from catalog_sections where level=".($level)." and altname='".$last_section."' and showmenu=1 limit 1";


        //echo "SELECT * from catalog_sections where level=$level and altname='".$segments[$level]."' and showmenu=1 limit 1";
        set_title($row['name'], 1);
        set_meta($row['keywords'], $row['description']);



        $res1=mysql_query("SELECT * from catalog_sections where parent={$row['id']} and showmenu=1 order by name");
        //echo "SELECT * from catalog_sections where parent={$row['id']} and showmenu=1";
        if(mysql_num_rows($res1)>0) {
            render_to_template("components/catalog/template.Header.php", array());
            render_to_template("components/catalog/template.Body.php", $row);
            if($res1) {
                while($row1=mysql_fetch_array($res1)){
                    $row1['link']=$PATH."/catalog/".$catalog."/".$row1['altname'];
                    render_to_template("components/catalog/template.section.php", $row1);
                }
            }
            render_to_template("components/catalog/template.Footer.php", array());
            //echo $segments[$level-1];
        } else {
        
            render_to_template("components/catalog/template.nothingFound.php", array());

        }
    }
} elseif(strpos($last_section, "item-")!==false) {//$csection=='item'

    //item
    //die('2');
    $idpos = (int) substr($last_section, 5);
    //echo $catalog."-cat<br>";
    //echo $idpos;
    //die();
    //$res=mysql_query("SELECT section_id WHERE b.id={$idpos}");
    $res = mysql_query("SELECT a.id as aid,a.description as adescription,a.characteristics,a.specification,a.alt, b.id as bid, b.oem as articule, b.model,b.description,b.price,b.keywords as keywords,b.country,b.provider,b.column1,b.column2,b.column3,b.column4,d.name as section,d.altname as altsection FROM catalog_items2 AS a, catalog_items AS b, catalog_sections AS d WHERE a.linked_item=b.name AND b.id={$idpos}");
    //mydump("SELECT a.id as aid,a.name as aname,a.description as adescription,a.alt,a.keywords as akeywords, b.*,c.id as modid,c.name as model,c.altname as altmodel,d.name as brand,d.altname as altbrand FROM catalog_items2 AS a, catalog_items AS b, catalog_subsections AS c, catalog_sections AS d WHERE a.linked_item=b.name AND b.subsection_id=c.id AND c.section_id=d.id AND a.id={$idpos}");

    //die('3');
    if ($row = mysql_fetch_assoc($res)) {
        $row['link']=$row['brand'];
        $row['model']=($row['altmodel'])?$row['altmodel']:$row['model'];
        $row['brand']=($row['altbrand'])?$row['altbrand']:$row['brand'];
        set_title($row['description']." ".$row['brand']." ".$row['model']);
        set_meta($row['keywords'], $SITE_TITLE.": ".$row['brand']." ".$row['model']);
        $row['breadcrumbs']=3;
        render_to_template("components/catalog/template.breadcrumbs.php", $row);
        render_to_template("components/catalog/template.showItem.php", $row);
        /*
        $v=explode(";",$row['oem_variants']);
        $v[]=$row['oem'];
        $qs="AND (1 = 0 ";
        foreach($v as $k){
        if($k){
        $qs.="OR b.oem = '$k' ";
        $qs.="OR b.oem_variants LIKE '%$k%' ";
        }
        }
        $qs.=")";
        */
        //show similar
        /*
        $similar_arr = array();
        $res2 = mysql_query("SELECT b.id AS bid,b.name AS bname,a.id, a.name AS position_name,b.oem,c.name AS modelname,
          c.altname AS altmodelname, c.showimg, b.price, b.quantity, b.description,b.waitingfor, d.name AS brandname,d.altname AS altbrandname,b.av,b.country FROM catalog_subsections AS c, catalog_sections AS d, catalog_items AS b LEFT JOIN catalog_items2 AS a ON b.name=a.linked_item WHERE b.subsection_id=c.id AND b.section_id=d.id AND b.id!= {$row['id']} 
          $qs 
          ORDER BY RAND() LIMIT 3");//AND b.quantity != 0
        while($row2 = mysql_fetch_array($res2)){
        if($row2[3]) $row2[1] = $row2[3];
        if($row2[6]) $row2[5] = $row2[6];
        $similar_arr[]=$row2;
        }
        render_to_template("components/catalog/template.showSimilar.php",$similar_arr);    
        */    
    } else {
        header("HTTP/1.0 404 Not Found");
        header("Location: " . $GLOBALS['PATH'] . "/404");
    }
    //die('item');

}










//mydump($csection,'csection');
//die();

/*

$arcquery=($_GET['stat']=='archive')?"AND b.waitingfor='архив'":"AND b.waitingfor!='архив'";
$id = mysql_real_escape_string($csection);
//echo $id;
//mydump($segments[2]);
if(!$segments[2] && strpos($csection, "item-")===false){
//if (strpos($id,"item-")===false && strpos($id,"product-")===false && strpos($id,"section-")===false && strpos($id,"price-")===false && strpos($id,"farm")===false){
    //section
    mydump("SELECT id,name,altname FROM catalog_sections WHERE LOWER(`name`)='$id'");
    
    $res = mysql_query("SELECT id,name,altname FROM catalog_sections WHERE LOWER(`name`)='$id'");
    if($row=mysql_fetch_row($res)){
    $res3=mysql_query("SELECT keywords,meta_description FROM static WHERE path='$id' limit 1");
    
    $row3=mysql_fetch_row($res3);
        if($row[2]) $row[1]=$row[2];
        set_title($row[1]);
        $row3[1]=($row3[1])?$row3[1]:$row[1];
        set_meta($row3[0],$GLOBALS[SITE_TITLE]." - ".$row3[1]);
        render_to_template("components/catalog/template.modelsHeader.php", array('title' => $row[1]));
        $res2 = mysql_query("SELECT id, name,altname, image FROM catalog_subsections WHERE section_id = " . $row[0] . " ORDER BY position");
        while($row2 = mysql_fetch_row($res2)){
            render_to_template("components/catalog/template.models.php", array('idsection'=>$id,'idsubsection'=>$row2[1],'name'=>$row2[2],'image'=>$row2[3],'id'=>$row2[0]));
        }
        render_to_template("components/catalog/template.modelsFooter.php",array());
    } else {
    //die('1');
    header("HTTP/1.0 404 Not Found");
    header("Location: " . $GLOBALS['PATH'] . "/404");
     }
} elseif($segments[2]!='item' && strpos($csection, "item-")===false){
    //section subsection
    $name=addslashes($segments[2]);
    $idpos= (int) substr($id, 8);
    $res=mysql_query("SELECT a.id, a.name as subsection, a.altname as altsubsection, a.showimg, b.name as section, b.altname as altsection,c.name as brand,a.sortby FROM catalog_subsections AS a, catalog_sections AS b, catalog_brands AS c WHERE LOWER(a.name) = '$name' AND a.section_id = b.id");

    //die();
    if($row=mysql_fetch_array($res)){
    
        
    $res3=mysql_query("SELECT keywords,meta FROM texts WHERE path='catalog/$id' limit 1");
    $row3=mysql_fetch_row($res3);

    $keys=($row3[0])?$row3[0]:"";
    $meta=($row3[1])?$row3[1]:"";
        if($row[2]) $row[1]=$row[2];
        $s=strtolower($row[4]);
        if($row[5]) $row[4]=$row[5];
        //var_dump($meta);
        if($meta!=''){
      if(strpos($meta,",")){
        $ptitle=substr($meta,0,strpos($meta,","));
      } else {
        $ptitle=$meta;
      }
        } else {
      $ptitle=$row[4]." - ".$row[1];
        }
        set_title($ptitle,0);
        //echo "title";var_dump($ptitle);
        $keys=($keys!='')?$keys:$row[4]." ".$row[1].", ".$row[4].", ".$row[4]." ".$row[1].", ".$row[1];    
    $meta=($meta!='')?$meta:$row[4]." - ".$row[1];
        set_meta($keys,$meta);
        $ressortby=mysql_query("select column1,column2,column3,column4 from catalog_items where subsection_id=".$row[0]);
        $row['sort'][1]=array();
        $row['sort'][2]=array();
        $row['sort'][3]=array();
        $row['sort'][4]=array();
        while($rowsortby=mysql_fetch_array($ressortby)){
            if(!in_array($rowsortby[0],$row['sort'][1])){
                $row['sort'][1][]=$rowsortby[0];
            }
            if(!in_array($rowsortby[1],$row['sort'][2])){
                $row['sort'][2][]=$rowsortby[1];
            }
            if(!in_array($rowsortby[2],$row['sort'][3])){
                $row['sort'][3][]=$rowsortby[2];
            }
            if(!in_array($rowsortby[3],$row['sort'][4])){
                $row['sort'][4][]=$rowsortby[3];
            }
        }
        asort($row['sort'][1]);
        asort($row['sort'][2]);
        asort($row['sort'][3]);
        asort($row['sort'][4]);
        $row['segments']=$segments;
        $resb=mysql_query("select name from catalog_brands where subsection_id=".$row[0]);
        while($rowb=mysql_fetch_array($resb)){
            $row['brands'][]=$rowb[0];
            //htmldump($segments[3]);
            //htmldump($rowb[0]);
            if(strtolower($rowb[0])==strtolower($segments[3])){
                $row['current']=$segments[3];
            }
        }
        
        //$row['title']=$row[4]." ".$row[1];
        //$row['brands']=$rowb;
        //mydump("select name from catalog_brands where subsection_id=".$row[0],'brands');
    $row['title']=$ptitle;
    $row['breadcrumbs']=2;
    render_to_template("components/catalog/template.breadcrumbs.php",$row);
    render_to_template("components/catalog/template.menu.php",$row);
    render_to_template("components/catalog/template.tableHeader.php",$row);
    $where="";
        if($segments[3]){
            $brand=mysql_real_escape_string($segments[3]);
            $where=" and LOWER(a.name)='".$brand."'";
        }
        if($_GET['c']){
            foreach($_GET['c'] as $num=>$val){
                if($val!='all'){
                    $n=(int) $num;
                    $q=mysql_real_escape_string(urldecode($val));
                    $where.=" and column".$n."='".$q."'";
                }
            }
        }
        if($_GET['s']=='down'){
            $order=" ORDER BY b.price*1 DESC";
        } elseif($_GET['s']=='up'){
            $order=" ORDER BY b.price*1 ASC";
        } else {
            $order=" ORDER BY b.model";
        }
        $res2=mysql_query("SELECT b.id,b.name AS position_name,b.oem,c.name AS modelname,c.altname AS altmodelname, b.price,b.quantity,b.waitingfor,b.description,b.special,b.available,b.country,b.provider,a.name as brand_name FROM catalog_brands as a, catalog_items AS b, catalog_subsections AS c WHERE b.subsection_id = c.id and b.brand_id=a.id and c.name='".$name."'".$where.$order);
                //mydump("SELECT b.id,b.name AS position_name,b.oem,c.name AS modelname,c.altname AS altmodelname, b.price,b.quantity,b.waitingfor,b.description,b.special,b.available,b.country,b.provider,a.name as brand_name FROM catalog_brands as a, catalog_items AS b, catalog_subsections AS c WHERE b.subsection_id = c.id and b.brand_id=a.id and c.name='".$name."'".$where." ORDER BY b.name");
                //mydump("SELECT b.id,b.name AS position_name,b.oem,c.name AS modelname,c.altname AS altmodelname, b.price,b.quantity,b.waitingfor,b.description,b.special,b.available,b.country,b.provider FROM catalog_items AS b, catalog_subsections AS c WHERE b.subsection_id = c.id  ORDER BY b.name");
        $s = 0;
        while($row2=mysql_fetch_row($res2)){
        //mydump($row2);
      $farm=substr($row2[1],0,3);
            $s++;
            if($row2[4]) $row2[3]=$row2[4];
            $sid=0;
            $res3=mysql_query("SELECT id,name,description FROM catalog_items2 WHERE linked_item = '{$row2[1]}'");
            //echo "SELECT * FROM catalog_items2 WHERE linked_item = '{$row2[1]}'";
            if($r3=mysql_fetch_row($res3)){
                $row2[1]=$r3[1];
                $sid=$r3[0];
            }
            if($row2[11]>0){
                $av=0;
            } elseif($row2[8]!="" && $row2[8]!=0){
                $av=2;
            } else {
                $av=1;
            }
            //htmldump($r3);
            //echo "testpage";
            render_to_template("components/catalog/template.tableIn.php",array('ftitle'=>$row[1],'info'=>$r3[2], 'btitle'=> $row[4],'id'=>$row2[0],'model'=>$row2[1],'oem'=>$row2[2],'name'=>$row2[3],'price'=>$row2[5],'quantity'=>$row2[6],'description'=>$row2[8],'av'=>$av,'country'=>$row2[11],'sid'=>$sid,'showimg'=>1,'action'=>$row2[9],'farm'=>$farm,'dimension'=>$row2[12],'brand'=>$row2[13]));//'showimg'=>$row[3]
        }
        if($s==0) echo "<tr><td colspan=8>Не найдено ни одной позиции</td></tr>";
        render_to_template("components/catalog/template.tableFooter.php",array());
    } else {
    //die('2');
    header("HTTP/1.0 404 Not Found");
    header("Location: " . $GLOBALS['PATH'] . "/404");
     }
} elseif(strpos($id, "section-")!==false){
    //section
    $idpos = (int) substr($id, 8);
    $sections=array("", "Оптика и зеркала", "Кузовные запчасти", "Аксессуары"); 
  $descs=array("", "Оптика и зеркала", "Кузовные запчасти", "Аксессуары");
  $keys=array("", "оптика", "Кузовные запчасти", "аксессуары");
    if(array_key_exists($idpos,$sections)){
        set_title($sections[$idpos]);
        set_meta($keys[$idpos].", запчасти для европейских грузовиков, автозапчасти для грузовых иномарок, грузовые запчасти","Грузовая запчасть - ".$descs[$idpos]);
        render_to_template("components/catalog/template.tableHeader2.php", array('title'=>$sections[$idpos],'tt'=>1,'showimg'=>1));
    $page=(preg_match("!^[0-9]+$!is",$_GET['p'],$match))?$_GET['p']:"";
  if(file_exists("cache/$id/page".$page.".php")){
  //cache
    if($_GET['stat']=='archive'){
      include_once "cache/$id/archpage".$page.".php";
    } else {
      include_once "cache/$id/page".$page.".php";
    }
      $s=1;
  } else {
    //загрузка из базы
        $res2 = mysql_query("SELECT b.id, b.name AS position_name, b.oem, c.name AS modelname, c.altname AS altmodelname, b.price, b.quantity,  b.waitingfor,   b.description, b.special, b.available, d.name, b.country AS brandname,b.provider FROM catalog_items AS b, catalog_subsections AS c, catalog_sections AS d WHERE b.subsection_id = c.id AND b.section_id = d.id $arcquery AND b.section = " . $idpos . " ORDER BY d.name,c.name,b.description");
        $s=0;
        while($row2=mysql_fetch_row($res2)){
            $s++;
            if ($row2[4]) $row2[3]=$row2[4];
            $sid=0;
            $res3=mysql_query("SELECT * FROM catalog_items2 WHERE linked_item = '{$row2[1]}'");
            if($r3=mysql_fetch_row($res3)){
                $row2[1]=$r3[1];
                $sid=$r3[0];
            }
            if($row2[10]>0){
                $av=0;
            } elseif($row2[7]!="" && $row2[7]!=0){
                $av=2;
            } else {
                $av=1;
            }    
            render_to_template("components/catalog/template.tableIn1.php", array('id'=>$row2[0],'name'=>$row2[1],'btitle'=>$row2[11],'ftitle'=>$row2[3],'oem'=>$row2[2],'model'=>$row2[3],'price'=>$row2[5],'quantity'=>$row2[6],'description'=>$row2[8],'av'=>$av,'country'=>$row2[12],'sid'=>$sid,'mlinks'=>1,'action'=>$row2[9],'showimg'=>1,'dimension'=>$row2[13]));
              }
        }
        if($s == 0) echo "<tr><td colspan=8>Не найдено ни одной позиции</td></tr>";
        render_to_template("components/catalog/template.tableFooter.php",array());
    } else {
    header("HTTP/1.0 404 Not Found");
    header("Location: " . $GLOBALS['PATH'] . "/404");
    }
} elseif(strpos($csection, "item-")!==false){//$csection=='item'
    //item
    $idpos = (int) substr($csection,5);
    $res = mysql_query("SELECT a.id as aid,a.description as adescription,a.characteristics,a.specification,a.alt,a.keywords as akeywords, b.id as bid, b.model,b.description,b.price,b.country,b.provider,b.column1,b.column2,b.column3,b.column4,c.id as modid,c.name as subsection,c.altname as altsubsection,d.name as section,d.altname as altsection,e.name as brand FROM catalog_items2 AS a, catalog_items AS b, catalog_subsections AS c, catalog_sections AS d,catalog_brands as e WHERE a.linked_item=b.name AND b.subsection_id=c.id AND c.section_id=d.id AND b.brand_id=e.id AND a.id={$idpos}");
    //mydump("SELECT a.id as aid,a.name as aname,a.description as adescription,a.alt,a.keywords as akeywords, b.*,c.id as modid,c.name as model,c.altname as altmodel,d.name as brand,d.altname as altbrand FROM catalog_items2 AS a, catalog_items AS b, catalog_subsections AS c, catalog_sections AS d WHERE a.linked_item=b.name AND b.subsection_id=c.id AND c.section_id=d.id AND a.id={$idpos}");

//die('3');
    if ($row = mysql_fetch_array($res)) {
        $row['link']=$row['brand'];
        $row['model']=($row['altmodel'])?$row['altmodel']:$row['model'];
        $row['brand']=($row['altbrand'])?$row['altbrand']:$row['brand'];
        set_title($row['description']." ".$row['brand']." ".$row['model']);
        set_meta($row['keywords'],$SITE_TITLE.": ".$row['brand']." ".$row['model']);
        $row['breadcrumbs']=3;
        render_to_template("components/catalog/template.breadcrumbs.php",$row);
        render_to_template("components/catalog/template.showItem.php",$row);
        $v=explode(";",$row['oem_variants']);
        $v[]=$row['oem'];
        $qs="AND (1 = 0 ";
        foreach($v as $k){
            if($k){
                $qs.="OR b.oem = '$k' ";
                $qs.="OR b.oem_variants LIKE '%$k%' ";
            }
        }
        $qs.=")";
        //show similar
        /*
        $similar_arr = array();
        $res2 = mysql_query("SELECT b.id AS bid,b.name AS bname,a.id, a.name AS position_name,b.oem,c.name AS modelname,
                            c.altname AS altmodelname, c.showimg, b.price, b.quantity, b.description,b.waitingfor, d.name AS brandname,d.altname AS altbrandname,b.av,b.country FROM catalog_subsections AS c, catalog_sections AS d, catalog_items AS b LEFT JOIN catalog_items2 AS a ON b.name=a.linked_item WHERE b.subsection_id=c.id AND b.section_id=d.id AND b.id!= {$row['id']} 
                            $qs 
                            ORDER BY RAND() LIMIT 3");//AND b.quantity != 0
        while($row2 = mysql_fetch_array($res2)){
            if($row2[3]) $row2[1] = $row2[3];
            if($row2[6]) $row2[5] = $row2[6];
            $similar_arr[]=$row2;
        }
        render_to_template("components/catalog/template.showSimilar.php",$similar_arr);    
        */    /*
    } else {
    //die('4');
    header("HTTP/1.0 404 Not Found");
    header("Location: " . $GLOBALS['PATH'] . "/404");
    }
} else {
//die('5');
header("HTTP/1.0 404 Not Found");
header("Location: " . $GLOBALS['PATH']."/404");
}
*/
?>