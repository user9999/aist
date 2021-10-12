<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
} 

if (!isset($_GET['id'])) { 

    header("HTTP/1.0 404 Not Found");
    header("Location: " . $GLOBALS['PATH'] . "/404");
}

if(strpos($_GET['id'], "item-")!==false && strpos($_GET['id'], "price-")!==false && strpos($_GET['id'], "farm-")!==false) {
    header("HTTP/1.0 404 Not Found");
    include "components/404/template.404.php";
    $PAGE_BODY = ob_get_contents();
    ob_clean();
    if (file_exists("templates/$TEMPLATE/$component.template.php")) {
        include "templates/$TEMPLATE/$component.template.php";
    } else {
        include "templates/$TEMPLATE/template1.php";
    }
    die();
}


$arcquery=($_GET['stat']=='archive')?"AND b.waitingfor='архив'":"AND b.waitingfor!='архив'";
$id = mysql_real_escape_string($_GET['id']);
//echo $id;
if (strpos($id, "item-")===false && strpos($id, "product-")===false && strpos($id, "section-")===false && strpos($id, "price-")===false && strpos($id, "farm")===false) {
    //category
    $res = mysql_query("SELECT id,name,altname FROM catalog_brands WHERE LOWER(`name`)='$id'");
    if($row=mysql_fetch_row($res)) {
        $res3=mysql_query("SELECT keywords,meta_description FROM static WHERE path='$id' limit 1");
    
        $row3=mysql_fetch_row($res3);
        if($row[2]) { $row[1]=$row[2];
        }
        set_title($row[1]);
        $row3[1]=($row3[1])?$row3[1]:$row[1];
        set_meta($row3[0], $GLOBALS[SITE_TITLE]." - ".$row3[1]);
        render_to_template("components/catalog/template.modelsHeader.php", array('title' => $row[1]));
        $res2 = mysql_query("SELECT id, name,altname, image FROM catalog_models WHERE brand_id = " . $row[0] . " ORDER BY position");
        while($row2 = mysql_fetch_row($res2)){
            render_to_template("components/catalog/template.models.php", array('name'=>$row2[2],'image'=>$row2[3],'id'=>$row2[0]));
        }
        render_to_template("components/catalog/template.modelsFooter.php", array());
    } else {
        header("HTTP/1.0 404 Not Found");
        header("Location: " . $GLOBALS['PATH'] . "/404");
    }
} elseif(strpos($id, "product-")!==false) {
    //category model
    $idpos= (int) substr($id, 8);
    //echo $idpos;
    //die();
    $res=mysql_query("SELECT a.id, a.name, a.altname, a.showimg, b.name as bname, b.altname as baltname FROM catalog_models AS a, catalog_brands AS b WHERE a.id = '$idpos' AND a.brand_id = b.id");
    if($row=mysql_fetch_array($res)) {
    
        //$row['dimension']='кг.';
        //$row['dimension']=($row[1]=='eggs')?'дес.':$row['dimension'];
        //$row['dimension']=($row[1]=='cowmilk' || $row[1]=='goatmilk')?'л.':$row['dimension'];
        
        $res3=mysql_query("SELECT keywords,meta FROM texts WHERE path='catalog/$id' limit 1");
        $row3=mysql_fetch_row($res3);
        //var_dump($row3);
        $keys=($row3[0])?$row3[0]:"";
        $meta=($row3[1])?$row3[1]:"";
        if($row[2]) { $row[1]=$row[2];
        }
        $s=strtolower($row[4]);
        if($row[5]) { $row[4]=$row[5];
        }
        //var_dump($meta);
        if($meta!='') {
            if(strpos($meta, ",")) {
                $ptitle=substr($meta, 0, strpos($meta, ","));
            } else {
                $ptitle=$meta;
            }
        } else {
            $ptitle=$row[4]." ".$row[1];
        }
        //$ptitle=($meta!='')?substr($meta,0,strpos($meta,",")):$row[4]." ".$row[1];
        set_title($ptitle, 0);
        //echo "title";var_dump($ptitle);
        $keys=($keys!='')?$keys:$row[4]." ".$row[1].", ".$row[4].", ".$row[4]." ".$row[1].", ".$row[1];    
        $meta=($meta!='')?$meta:$row[4]." ".$row[1];
        set_meta($keys, $meta);
        
        //$row['title']=$row[4]." ".$row[1];
        $row['title']=$ptitle;
        render_to_template("components/catalog/template.tableHeader.php", $row);
        $res2=mysql_query("SELECT b.id,b.name AS position_name,b.oem,c.name AS modelname,c.altname AS altmodelname, b.price,b.quantity,b.waitingfor,b.description,b.special,b.available,b.country,b.provider FROM catalog_items AS b, catalog_models AS c WHERE b.model_id = c.id $arcquery AND (b.model_id = " . $idpos . " OR b.model_variants LIKE '%{$row[1]}%') ORDER BY b.name");
        $s = 0;
        while($row2=mysql_fetch_row($res2)){
            $farm=substr($row2[1], 0, 3);
            $s++;
            if($row2[4]) { $row2[3]=$row2[4];
            }
            $sid=0;
            $res3=mysql_query("SELECT * FROM catalog_items2 WHERE linked_item = '{$row2[1]}'");
            if($r3=mysql_fetch_row($res3)) {
                $row2[1]=$r3[1];
                $sid=$r3[0];
            }
            if($row2[10]>0) {
                $av=0;
            } elseif($row2[7]!="" && $row2[7]!=0) {
                $av=2;
            } else {
                $av=1;
            }
            render_to_template("components/catalog/template.tableIn.php", array('tabindex'=>$s,'ftitle'=>$row[1],'btitle'=> $row[4],'id'=>$row2[0],'name'=>$row2[1],'oem'=>$row2[2],'model'=>$row2[3],'price'=>$row2[5],'quantity'=>$row2[6],'description'=>$row2[8],'av'=>$av,'country'=>$row2[11],'sid'=>$sid,'showimg'=>1,'action'=>$row2[9],'farm'=>$farm,'dimension'=>$row2[12]));//'showimg'=>$row[3]
        }
        if($s==0) { echo "<tr><td colspan=8>Не найдено ни одной позиции</td></tr>";
        }
        render_to_template("components/catalog/template.tableFooter.php", array());
    } else {
        header("HTTP/1.0 404 Not Found");
        header("Location: " . $GLOBALS['PATH'] . "/404");
    }
} elseif(strpos($id, "farm-")!==false) {


    /////////////begin

    $idpos=substr($id, 5);
    //echo $idpos;
    //echo $_GET['id'];die(); 
    //$res=mysql_query("SELECT a.id, a.name, a.altname, a.showimg, b.name as bname, b.altname as baltname FROM catalog_models AS a, catalog_brands AS b WHERE a.id like '$idpos%' AND a.brand_id = b.id");
    //die("SELECT a.id, a.name, a.altname, a.showimg, b.name as bname, b.altname as baltname FROM catalog_models AS a, catalog_brands AS b WHERE a.id like '$idpos%' AND a.brand_id = b.id");


    //die("SELECT b.id,b.name AS position_name,b.oem,c.name AS modelname,c.altname AS altmodelname, b.price,b.quantity,b.waitingfor,b.description,b.special,b.available,b.country,b.provider FROM catalog_items AS b, catalog_models AS c WHERE b.model_id = c.id AND (b.name like '" . $idpos . "%' OR b.model_variants LIKE '%{$row[1]}%') ORDER BY b.description");
    $res3=mysql_query("SELECT keywords,meta FROM texts WHERE path='catalog/$id' limit 1");
    $row3=mysql_fetch_row($res3);
    $res=mysql_query("SELECT country from catalog_items where name like '$idpos%'");
    //echo "SELECT country from catalog_items where name like '$idpos%'";
    $row=mysql_fetch_row($res);
    //var_dump($row3);
    $keys=($row3[0])?$row3[0]:"";
    $meta=($row3[1])?$row3[1]:"";
    if($row[2]) { $row[1]=$row[2];
    }
    $s=strtolower($row[4]);
    if($row[5]) { $row[4]=$row[5];
    }
    //var_dump($meta);
    if($meta!='') {
        if(strpos($meta, ",")) {
            $ptitle=substr($meta, 0, strpos($meta, ","));
        } else {
            $ptitle=$meta;
        }
    } else {
        $ptitle="Продукция ".$row[0];
    }
    //$ptitle=($meta!='')?substr($meta,0,strpos($meta,",")):$row[4]." ".$row[1];
    set_title($ptitle, 0);
    //echo "title";var_dump($ptitle);
    //$keys=($keys!='')?$keys:$row[4]." ".$row[1].", ".$row[4].", ".$row[4]." ".$row[1].", ".$row[1];    
    $keys=($keys!='')?$keys:$META_KEYWORDS;
    //$meta=($meta!='')?$meta:$row[4]." ".$row[1];
    $meta=($meta!='')?$meta:$ptitle;
    $meta=($meta!='')?$meta:$META_DESCRIPTION;
    set_meta($keys, $meta);
        
    //$row['title']=$row[4]." ".$row[1];
    $row['title']=$ptitle;
    $row['cat']="Каталог";
    render_to_template("components/catalog/template.tableHeader.php", $row);
    $res2=mysql_query("SELECT b.id,b.name AS position_name,b.oem,c.name AS modelname,c.altname AS altmodelname, b.price,b.quantity,b.waitingfor,b.description,b.special,b.available,b.country,b.provider FROM catalog_items AS b, catalog_models AS c WHERE b.model_id = c.id AND b.name like '" . $idpos . "%' ORDER BY b.description");
    $s = 0;
    //echo "SELECT b.id,b.name AS position_name,b.oem,c.name AS modelname,c.altname AS altmodelname, b.price,b.quantity,b.waitingfor,b.description,b.special,b.available,b.country,b.provider FROM catalog_items AS b, catalog_models AS c WHERE b.model_id = c.id AND b.name like '" . $idpos . "%' ORDER BY b.description";
    if($row2=mysql_num_rows($res2)) {
        while($row2=mysql_fetch_row($res2)){
            $farm=substr($row2[1], 0, 3);
            $s++;
            if($row2[4]) { $row2[3]=$row2[4];
            }
            $sid=0;
            $res3=mysql_query("SELECT * FROM catalog_items2 WHERE linked_item = '{$row2[1]}'");
            if($r3=mysql_fetch_row($res3)) {
                   $row2[1]=$r3[1];
                   $sid=$r3[0];
            }
            if($row2[10]>0) {
                $av=0;
            } elseif($row2[7]!="" && $row2[7]!=0) {
                $av=2;
            } else {
                $av=1;
            }
            render_to_template("components/catalog/template.tableIn.php", array('tabindex'=>$s,'ftitle'=>$row[1],'btitle'=> $row[4],'id'=>$row2[0],'name'=>$row2[1],'oem'=>$row2[2],'model'=>$row2[3],'price'=>$row2[5],'quantity'=>$row2[6],'description'=>$row2[8],'av'=>$av,'country'=>$row2[11],'sid'=>$sid,'showimg'=>1,'action'=>$row2[9],'farm'=>$farm,'dimension'=>$row2[12]));//'showimg'=>$row[3]
        }
        if($s==0) { echo "<tr><td colspan=8>Не найдено ни одной позиции</td></tr>";
        }
        render_to_template("components/catalog/template.tableFooter.php", array());
    } else {
        header("HTTP/1.0 404 Not Found");
        header("Location: " . $GLOBALS['PATH'] . "/404");
    }
    /////////end
  
  
} elseif(strpos($id, "section-")!==false) {
    //section
    $idpos = (int) substr($id, 8);
    $sections=array("", "Оптика и зеркала", "Кузовные запчасти", "Аксессуары"); 
    $descs=array("", "Оптика и зеркала", "Кузовные запчасти", "Аксессуары");
    $keys=array("", "оптика", "Кузовные запчасти", "аксессуары");
    if(array_key_exists($idpos, $sections)) {
        set_title($sections[$idpos]);
        set_meta($keys[$idpos].", запчасти для европейских грузовиков, автозапчасти для грузовых иномарок, грузовые запчасти", $SITE_TITLE." - ".$descs[$idpos]);
        render_to_template("components/catalog/template.tableHeader2.php", array('title'=>$sections[$idpos],'tt'=>1,'showimg'=>1));
        $page=(preg_match("!^[0-9]+$!is", $_GET['p'], $match))?$_GET['p']:"";
        if(file_exists("cache/$id/page".$page.".php")) {
            //cache
            if($_GET['stat']=='archive') {
                include_once "cache/$id/archpage".$page.".php";
            } else {
                include_once "cache/$id/page".$page.".php";
            }
            $s=1;
        } else {
            //загрузка из базы
            $res2 = mysql_query("SELECT b.id, b.name AS position_name, b.oem, c.name AS modelname, c.altname AS altmodelname, b.price, b.quantity,  b.waitingfor,   b.description, b.special, b.available, d.name, b.country AS brandname FROM catalog_items AS b, catalog_models AS c, catalog_brands AS d WHERE b.model_id = c.id AND b.brand_id = d.id $arcquery AND b.section = " . $idpos . " ORDER BY d.name,c.name,b.description");
            $s=0;
            while($row2=mysql_fetch_row($res2)){
                $s++;
                if ($row2[4]) { $row2[3]=$row2[4];
                }
                $sid=0;
                $res3=mysql_query("SELECT * FROM catalog_items2 WHERE linked_item = '{$row2[1]}'");
                if($r3=mysql_fetch_row($res3)) {
                    $row2[1]=$r3[1];
                    $sid=$r3[0];
                }
                if($row2[10]>0) {
                    $av=0;
                } elseif($row2[7]!="" && $row2[7]!=0) {
                    $av=2;
                } else {
                    $av=1;
                }    
                render_to_template("components/catalog/template.tableIn1.php", array('id'=>$row2[0],'name'=>$row2[1],'btitle'=>$row2[11],'ftitle'=>$row2[3],'oem'=>$row2[2],'model'=>$row2[3],'price'=>$row2[5],'quantity'=>$row2[6],'description'=>$row2[8],'av'=>$av,'country'=>$row2[12],'sid'=>$sid,'mlinks'=>1,'action'=>$row2[9],'showimg'=>1));
            }
        }
        if($s == 0) { echo "<tr><td colspan=8>Не найдено ни одной позиции</td></tr>";
        }
        render_to_template("components/catalog/template.tableFooter.php", array());
    } else {
        header("HTTP/1.0 404 Not Found");
        header("Location: " . $GLOBALS['PATH'] . "/404");
    }
} elseif(strpos($id, "item-")!== false) {
    //item
    $idpos = (int) substr($id, 5);
    $res = mysql_query("SELECT a.id as aid,a.name as aname,a.description as adescription,a.alt,a.keywords as akeywords, b.*,c.id as modid,c.name as model,c.altname as altmodel,d.name as brand,d.altname as altbrand FROM catalog_items2 AS a, catalog_items AS b, catalog_models AS c, catalog_brands AS d WHERE a.linked_item=b.name AND b.model_id=c.id AND c.brand_id=d.id AND a.id={$idpos}");
    if ($row = mysql_fetch_array($res)) {
    
        //$row['dimension']='кг.';
        //$row['dimension']=($row['model']=='eggs')?'дес.':$row['dimension'];
        //$row['dimension']=($row['model']=='cowmilk' || $row['model']=='goatmilk')?'л.':$row['dimension'];

        //$trep = array(", правое",", переднее",", левое",", заднее",", левый ",", правый",", переднее/заднее",", левая", ", правая","U");
        //$tit=str_replace($trep,"",$row[1]);
        
        $row['link']=$row['brand'];
        $row['model']=($row['altmodel'])?$row['altmodel']:$row['model'];
        $row['brand']=($row['altbrand'])?$row['altbrand']:$row['brand'];
        set_title($row['brand']." - ".$row[1], 0);
        set_meta($row['keywords'], $SITE_TITLE.": ".$row['brand']." - ".$row[1]);
        
        render_to_template("components/catalog/template.showItem.php", $row);
        $v=explode(";", $row['oem_variants']);
        $v[]=$row['oem'];
        $qs="AND (1 = 0 ";
        foreach($v as $k){
            if($k) {
                $qs.="OR b.oem = '$k' ";
                $qs.="OR b.oem_variants LIKE '%$k%' ";
            }
        }
        $qs.=")";
        //show similar
        /*
        $similar_arr = array();
        $res2 = mysql_query("SELECT b.id AS bid,b.name AS bname,a.id, a.name AS position_name,b.oem,c.name AS modelname,
                            c.altname AS altmodelname, c.showimg, b.price, b.quantity, b.description,b.waitingfor, d.name AS brandname,d.altname AS altbrandname,b.av,b.country FROM catalog_models AS c, catalog_brands AS d, catalog_items AS b LEFT JOIN catalog_items2 AS a ON b.name=a.linked_item WHERE b.model_id=c.id AND b.brand_id=d.id AND b.id!= {$row['id']} 
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
} elseif(strpos($id, "plastic")!==false) {

    if($id=="plastic") {
        $res3=mysql_query("SELECT keywords,meta_description FROM static WHERE path='$id' limit 1");
        $row3=mysql_fetch_row($res3);
        $res = mysql_query("SELECT id,name,altname FROM catalog_brands WHERE showmenu=1 order by position");
        set_title("Автопластик. Пластик Daf, пластик Iveco, пластик Man, пластик Renault, пластик Scania, пластик Mercedes, пластик Volvo");
        set_meta($row3[0], $row3[1]);
        render_to_template("components/catalog/template.modelsHeader.php", array('tt'=>'','title'=>"Автопластик"));
        while($row=mysql_fetch_row($res)){
            $pid=strtolower($row[1]);
            if(file_exists("img/plastic/".$pid.".jpg")) {
                $img="img/plastic/".$pid.".jpg";
            } else {
                $img="img/nofoto.jpg";
            }
         
            $name=($row[2])?$row[2]:$row[1];
            render_to_template("components/catalog/template.models.php", array('name'=>'Пластик '.$name,'image'=>$img,'id'=>$pid));//?
        }
        render_to_template("components/catalog/template.modelsFooter.php", array());
 
    } else {
        $idpos=substr($id, 8);
         //загрузка из базы
        $models=Array("daf"=>"DAF","m-b"=>"Mercedes","iveco"=>"Iveco","scania"=>"Scania","man"=>"Man","volvo"=>"Volvo","renault"=>"Renault");
        set_title('Пластик '.$models[$idpos]);
        set_meta('Пластик '.$models[$idpos], 'Кузовные запчасти, пластик '.$models[$idpos]);
        render_to_template("components/catalog/template.tableHeader2.php", array('title'=>'','tt'=>1,'showimg'=>1,'bname'=>$models[$idpos]));
        $res2 = mysql_query("SELECT b.id, b.name AS position_name, b.oem, c.name AS modelname, c.altname AS altmodelname, b.price, b.quantity,  b.waitingfor,   b.description, b.special, b.available, d.name, b.country AS brandname FROM catalog_items2 as a,catalog_items AS b,catalog_models AS c,catalog_brands AS d WHERE a.linked_item=b.name and b.model_id = c.id AND b.brand_id = d.id AND d.name='$idpos' AND (a.description like '%пластик%' OR a.description like '%поли%') ORDER BY b.description");//c.name,b.description
        //echo "SELECT b.id, b.name AS position_name, b.oem, c.name AS modelname, c.altname AS altmodelname, b.price, b.quantity,  b.waitingfor,   b.description, b.special, b.available, d.name, b.country AS brandname FROM catalog_items2 as a,catalog_items AS b,catalog_models AS c,catalog_brands AS d WHERE a.linked_item=b.name and b.model_id = c.id AND b.brand_id = d.id AND d.name=$idpos AND a.description like '%пластик%' ORDER BY c.name,b.description";
 
        $s=0;
        while($row2=mysql_fetch_row($res2)){
            $s++;
            if ($row2[4]) { $row2[3]=$row2[4];
            }
            $sid=0;
            $res3=mysql_query("SELECT * FROM catalog_items2 WHERE linked_item = '{$row2[1]}'");
            if($r3=mysql_fetch_row($res3)) {
                $row2[1]=$r3[1];
                $sid=$r3[0];
            }
            if($row2[10]>0) {
                $av=0;
            } elseif($row2[7]!="" && $row2[7]!=0) {
                $av=2;
            } else {
                $av=1;
            }    
            render_to_template("components/catalog/template.tableIn1.php", array('id'=>$row2[0],'name'=>$row2[1],'btitle'=>$row2[11],'ftitle'=>$row2[3],'oem'=>$row2[2],'model'=>$row2[3],'price'=>$row2[5],'quantity'=>$row2[6],'description'=>$row2[8],'av'=>$av,'country'=>$row2[12],'sid'=>$sid,'mlinks'=>1,'action'=>$row2[9],'showimg'=>1));
        }  
        render_to_template("components/catalog/template.tableFooter.php", array());
    }

} else {

    header("HTTP/1.0 404 Not Found");
    header("Location: " . $GLOBALS['PATH']."/404");
}
?>